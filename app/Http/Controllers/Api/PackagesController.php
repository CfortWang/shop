<?php

namespace App\Http\Controllers\Api;

use Validator;
use App;
use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Q35Sales;
use App\Models\Q35Package;
use App\Models\Q35SingleCode;
use App\Models\SalesPartner;
use App\Models\PartnerAccount;
use App\Models\Q35SalesItem;
use App\Models\BuyingRequest;
use App\Models\Buyer;

class PackagesController extends Controller
{
    public function __construct()
    {
    }
    //购买记录列表
    public function packageSales(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $limit=$request->input('limit')?$request->input('limit'):20;
        $page=$request->input('page')?$request->input('page'):1;
        $searchValue = $request->input('value');
        // $orderColumnsNo = $request->order[0]['column'];
        // $orderType = $request->order[0]['dir'];
        // $columnArray = array('total_quantity', 'payment_type', 'created_at', 'status');
        $items = Q35Sales::where('buyer',$buyer);
        if ($searchValue) {
            $items = $items->where('total_quantity', 'like', '%'.$searchValue.'%')
                           ->orWhere('payment_type', 'like', '%'.$searchValue.'%');
        }
        if($request->status){
            $items =  $items->where('status',$request->status);
        }
        $count = $items->count();
        $items = $items->select('total_quantity', 'payment_type', 'created_at', 'status', 'seq')
                // ->orderBy($columnArray[$orderColumnsNo], $orderType)
                ->limit($limit)  
                ->offset(($page-1)*$limit) 
                ->get();
        return $this->responseOk('',$items);
    }
    public function salesDetail(Request $request)
    {
        $seq=$request->input('seq');
        $buyer = $request->session()->get('buyer.seq');
        $Q35Sales = Q35Sales::where('buyer',$buyer)
                            ->where('seq',$seq)
                            ->select('buyer','sales_partner','total_sales_price','total_quantity','total_shipping_price','total_price','payment_type',
                            'pay_status','status')
                            ->first();
        if(empty($Q35Sales)){
            return $this->responseNotFound('There is no seq');
        }
        $sales = SalesPartner::where('seq',$Q35Sales->sales_partner)->select('partner_account')->first();
        $partner_id = PartnerAccount::where('seq',$sales->partner_account)->select('id')->first();
        $buyerId = Buyer::where('seq',$Q35Sales->buyer)->select('id')->first();
        $Q35Sales->partner = $partner_id->id;
        $Q35Sales->buyer_id = $buyerId->id;
        
        if (empty($Q35Sales)){
            return $this->responseNotFound('There is no data');//error code 404,401
        }else{
            $data['buyer']= $buyerId->id;
            $data['sales_partner']= $partner_id->id;
            $data['total_sales_price']= $Q35Sales->total_sales_price;
            $data['total_quantity']= $Q35Sales->total_quantity;
            $data['total_shipping_price']= $Q35Sales->total_shipping_price;
            $data['total_price']= $Q35Sales->total_price;
            $data['payment_type']= $Q35Sales->payment_type;
            $data['pay_status']= $Q35Sales->pay_status;
            $data['status']=$Q35Sales->status;
            return $this->responseOK('',$data);
        }

    }
    //购买记录详情列表
    public function salesItem(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $limit=$request->input('limit')?$request->input('limit'):20;
        $page=$request->input('page')?$request->input('page'):1;
        $seq=$request->input('seq');
        $searchValue = $request->input('value');
        // $orderColumnsNo = $request->order[0]['column'];
        // $orderType = $request->order[0]['dir'];

        // $salesItem = Q35SalesItem::where('q35sales', $seq)->where('type', $request->type)->first();
        // $salesItemSeq = $salesItem->seq;
        // $salesItemseq = null;
        // $columnArray = array('code','type', 'start_q35code', 'end_q35code', 'status');
        $items = Q35Package::join('Q35SalesItem as SI', 'SI.seq', '=', 'Q35Package.q35sales_item')
        // ->where('SI.q35sales', $seq)
            ->where('SI.type', $request->type);
        if ($searchValue) {
            $items=$items->where('seq', $searchValue);
        }
        if($request->status){
            $items =  $items->where('status',$request->status);
        }
        $count = $items->count();
        $items = $items->select('Q35Package.code', 'Q35Package.type', 'Q35Package.start_q35code', 'Q35Package.end_q35code', 'Q35Package.status', 'Q35Package.seq')
                // ->orderBy($columnArray[$orderColumnsNo], $orderType)
                ->limit($limit)  
                ->offset(($page-1)*$limit) 
                ->get();
        $data['data'] = $items;
        $data['count'] = $count;
        return $this->responseOk('',$data);
    }
    //喜豆码物流状态
    public function itemDetail(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $seq=$request->input('seq');
        $Q35SalesItem = Q35SalesItem::where('buyer',$buyer)
                                    ->where('q35sales',$seq);
        if($request->type){
            $Q35SalesItem =  $Q35SalesItem->where('type',$request->type);
        }
        $Q35SalesItem = $Q35SalesItem->select('quantity','shipping_status')->first();
        if (empty($Q35SalesItem)){
            return $this->responseNotFound('There is no data', 401);//error code 404,401
        }else{
            return $this->responseOK('success',$Q35SalesItem);
        }
    }

    public function received(Request $request,$seq)
    {
        $buyer = $request->session()->get('buyer.seq');
        $validator = Validator::make([
            'seq'    => $seq,
        ],[
            'seq'    => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('parameter is invalid');
        }

        $Q35SalesItem = Q35SalesItem::where('buyer',$buyer)
                                    ->where('seq',$seq)
                                    ->where('shipping_status','shipping')
                                    ->first();
        if (empty($Q35SalesItem)) {
            return $this->responseNotFound('No data');
        }

        $Q35SalesItem->shipping_status = 'completed';
        $Q35SalesItem->status = 'completed';
        $Q35SalesItem->completed_at = now();
        $Q35SalesItem->save();

        $allQ35SalesItem = Q35SalesItem::where('q35sales', $Q35SalesItem->q35sales)->get();
        $checkAll = 0;
        for ($i=0; $i<count($allQ35SalesItem); $i++) {
            if ($allQ35SalesItem[$i]->status === 'completed') {
                $checkAll++;
            }
        }

        if ($checkAll === count($allQ35SalesItem)) {
            $sales = Q35Sales::find($Q35SalesItem->q35sales);
            $sales->status = 'completed';
            $sales->save();
        }
        return $this->responseOK('Ok',$Q35SalesItem);
    }

    public function buyerRequest(Request $request){
        $buyer = $request->session()->get('buyer.seq');
        $offset = $request->start;
        $limit = $request->length;
        $searchValue = $request->search['value'];
        $orderColumnsNo = $request->order[0]['column'];
        $orderType = $request->order[0]['dir'];

        $columnArray = array('BuyingRequest.request_quantity', 'PA.id', 'BuyingRequest.created_at', 'BuyingRequest.confirmed_at', 'BuyingRequest.completed_at', 'BuyingRequest.status');

        $items = BuyingRequest::join('SalesPartner as SP', 'SP.seq', '=', 'BuyingRequest.sales_partner')
        ->join('PartnerAccount as PA', 'PA.seq', '=', 'SP.partner_account')
        ->where('BuyingRequest.buyer',$buyer);
        
        $recordsTotal = $items->count();
        
        if (!empty($request->search['value'])) {
            $items = $items->where(function ($query) use ($searchValue) {
                $query
                ->where('BuyingRequest.request_quantity', 'like', '%'.$searchValue.'%')
                ->where('PA.id', 'like', '%'.$searchValue.'%');
            });
        }
        
        if($request->status){
            $items =  $items->where('BuyingRequest.status',$request->status);
        }
        $recordsFiltered = $items->count();
        $items = $items->select('BuyingRequest.request_quantity', 'PA.id as partner_id', 'BuyingRequest.created_at', 'BuyingRequest.confirmed_at', 'BuyingRequest.completed_at', 'BuyingRequest.status', 'BuyingRequest.seq')
                ->orderBy($columnArray[$orderColumnsNo], $orderType)
                ->offset($offset)
                ->limit($limit)
                ->get();
        // if($items){
        //     $Buyer = Buyer::where('seq',$buyer)->first();
        //     $sales = SalesPartner::where('seq',$Buyer->sales_partner)->first();
        //     $partner_id = PartnerAccount::where('seq',$sales->partner_account)->select('id')->first();
        // }
        // foreach ($items as $item) {
        //     $item->partner_id = $partner_id->id;
        // }
        return $this->response4DataTables($items, $recordsTotal, $recordsFiltered);
    }

    public function buyingCreate(Request $request){
        $buyer = $request->session()->get('buyer.seq');

        $input = Input::only('id');
        $validator = Validator::make($input, [
            'id'           => 'required|string|min:1',
        ]);
        if ($validator->fails()) {
            return $this->responseBadRequest('Wrong Request', 401);//error code 400,401
        }
        $Buyer  = Buyer::where('seq',$buyer)->first();

        if (empty($Buyer)) {
            return $this->responseNotFound('No data', 401);//error code 404,401
        }

        $BuyingRequest = BuyingRequest::create([
            'request_quantity'             => $input['id'],
            'status'                       => 'requested',
            'sales_partner'                => $Buyer->sales_partner,
            'buyer'                        => $buyer,
        ]);

        return $this->responseOK('success', $BuyingRequest);
    }
    //我的喜豆码列表
    public function myPackageList(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $limit = $request->input('limit')?$request->input('limit'):20;
        $page = $request->input('page')?$request->input('page'):1;
        $packages = Q35Sales::where('buyer',$buyer)
            ->where('status', 'completed')
            ->where('pay_status', 'paid')
            ->select('seq')
            ->get();
        $packages = $packages->map(function($package){
            return $package->seq;
        });
        $items = Q35Package::whereIn('q35sales', $packages);
        if($request->status){
            $items =  $items->where('status',$request->status);
        }
        $recordsFiltered = $items->count();
        $items = $items->select('code', 'total_cnt', 'used_cnt', 'sold_at', 'activated_at', 'status', 'seq')
                ->limit($limit)  
                ->offset(($page-1)*$limit) 
                ->get();
        return $this->responseOk('',$items);
    }

    public function refundSales(Request $request, $seq)
    {
        $buyer = $request->session()->get('buyer.seq');
        $validator = Validator::make([
            'seq'    => $seq,
        ],[
            'seq'    => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('parameter is invalid');
        }

        $Q35Sales = Q35Sales::find($seq);

        if (empty($Q35Sales)) {
            return $this->responseNotFound('No data');
        }

        $Q35SalesItem = Q35SalesItem::where('q35sales', $seq)->get();

        if ($Q35SalesItem->count() === 0) {
            return $this->responseNotFound('No data');
        }

        $Q35Sales->refund_status = 'requested';
        $Q35Sales->status = 'refunded';
        $Q35Sales->refund_requested_at = now();
        $Q35Sales->save();

        foreach ($Q35SalesItem as $salesItem) {
            $salesItem->status = 'refunded';
            $salesItem->refunded_at = now();
            $salesItem->save();
        }

        return $this->responseOK('Ok', $Q35SalesItem);
    }
    //喜豆码详情列表
    public function codeList(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $limit = $request->input('limit')?$request->input('limit'):20;
        $page = $request->input('page')?$request->input('page'):1;
        $seq = $request->input('seq');
        $searchValue = $request->input('value');
        // dd($searchValue);
        $orderColumnsNo = $request->order[0]['column'];
        $orderType = $request->order[0]['dir'];
        // $columnArray = array('code', 'activated_at', 'used_at', 'status');
        $items = Q35SingleCode::where('q35package', $seq);
        $count = $items->count();
        if ($searchValue) {
            $items =  $items->where('seq',$searchValue);
        }
        if($request->status){
            $items =  $items->where('status',$request->status);
        }
        $items = $items->select('seq', 'seq as code', 'activated_at', 'used_at', 'status')
                // ->orderBy($columnArray[$orderColumnsNo], $orderType)
                ->limit($limit)
                ->offset(($page-1)*$limit) 
                ->get();
        $data['data'] = $items;
        $data['count'] = $count;
        return $this->responseok('',$data);
    }
    public function myPackageDetail(Request $request)
   {
        $buyer = $request->session()->get('buyer.seq');
        $seq = $request->input('seq');
        $package = Q35Package::where('seq', $seq)->select('seq','q35sales','code','type','start_q35code','end_q35code','status','total_cnt','used_cnt','sold_at','activated_at')->first();
        if(empty($package)){
            return $this->responseBadRequest('seq is error');//
        }
        $checkBuyer = Q35Sales::where('seq', $package->q35sales)->first();

        if ($buyer !== $checkBuyer->buyer) {
            return $this->responseBadRequest('Wrong Request', 401);//error code 400,401
        }
        return $this->responseok('',$package);
   }
    public function codeActivation(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $input = Input::only([
            'pkg_seq'
        ]);

        $validator = Validator::make($input,[
            'pkg_seq'           => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('Wrong Request', 401);//error code 400,401
        }

        $package = Q35Package::find($input['pkg_seq']);

        $salesCheck = Q35Sales::find($package->q35sales);

        if ($buyer !== $salesCheck->buyer) {
            return $this->responseBadRequest('Wrong Request', 401);//error code 400,401
        }
        
        $package->status = 'activated';
        $package->activated_at = now();
        $package->save();

        Q35SingleCode::where('q35package', $package->seq)->update([
            'status'         => 'activated',
            'activated_at'   => now()
        ]);
        
        return $this->responseOK('success', $package);
    }

}
