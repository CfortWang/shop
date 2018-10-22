<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;

use App\Models\Buyer;
use App\Models\SalesPartner;
use App\Models\BuyerPoint;
use App\Models\Bank;
use App\Models\PartnerAccount;
use App\Models\BuyerCashOutRequest;



class AccountInfoController extends Controller
{
     //账号基本信息
    public function detail(Request $request)
    {
        // $seq = $request->session()->get('buyer.seq');
        $seq=14;
        $data= Buyer::where('seq', $seq)
        // ->join('PartnerAccount as p', 'p.seq', '=', 'Buyer.sales_partner')
        ->select([
            'id',
            'rep_name',
            'rep_phone_num',
            'point',
            'bank_account',
            'bank_account_owner',
            'bank',
            'sales_partner'
        ])
        ->first();
        $PartnerAccount=PartnerAccount::where('seq',$data->sales_partner)->select('id')->first();
        $list['rep_name'] =$data['rep_name'];
        $list['rep_phone_num'] =$data['rep_phone_num'];
        $list['bank'] =$data['bank'];
        $list['bank_account'] =$data['bank_account'];
        $list['bank_account_owner'] =$data['bank_account_owner'];
        $list['partner_id'] =$PartnerAccount['id'];
        if (empty($data)) {
            return $this->responseNotFound('There is no buyer.');
        }
        return $this->responseOK('Success.', $list);
    }
    //积分列表
    public function scoreList(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
        $seq=14;
        $limit = $request->input('limit',10);
        $page = $request->input('page',1);
        $searchValue = $request->input('search');
        $items = BuyerPoint::where('buyer', $seq);
        $count = $items->count();
        if (!empty( $searchValue)) {
            $items = $items->where(function ($query) use ($searchValue) {
                $query
                ->where('type', 'like', '%'.$searchValue.'%')
                ->orWhere('signed_point', 'like', '%'.$searchValue.'%')
                ->orWhere('remain_point', 'like', '%'.$searchValue.'%');
            });
        }
        $items = $items->select(
                    'type as description',
                    'signed_point',
                    'remain_point',
                    'created_at',
                    'seq'
                )
                ->limit($limit)
                ->offset(($page-1)*$limit) 
                ->get();
        $data['data'] = $items;
        $data['count'] = $count;
        return $this->responseOK('',$data);
    }
    public function modify(Request $request){
        $seq = $request->session()->get('buyer.seq');
        $input = Input::only([  
            'rep_name',
            'bank_seq',
            'bank_account',
            'bank_account_owner',
            ]
        );
        $AccountInfoDetail = Buyer::find($seq);
        if(empty($AccountInfoDetail)){
            return $this->responseNotFound('No data','','');
        }
        $AccountInfoDetail->rep_name = $request->input('rep_name');
        $AccountInfoDetail->bank = $request->input('bank_seq');
        $AccountInfoDetail->bank_account = $request->input('bank_account');
        $AccountInfoDetail->bank_account_owner = $request->input('bank_account_owner');
        
        $AccountInfoDetail->save();
        return $this->responseOK('Success',1);
    }

    public function bankList(Request $request){
        $lang = $request->session()->get('bw.locale');
        $lang="zh";
        $data = Bank::select('seq', 'name_'.$lang.' as name')->where('name_'.$lang,'!=',null)->orderBy('seq', 'asc')->get();
        return $this->responseOk('',$data);
    }
    public function cashList(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
        $lang='zh';
        $buyer = Buyer::find($seq);
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $searchValue = $request->input('search');
        // $status = $request->status;
        // $orderColumnsNo = $request->order[0]['column'];
        // $orderType = $request->order[0]['dir'];
        // $columnArray = [
        //     'BuyerCashOutRequest.amount',
        //     'Buyer.id',
        //     'B.name_'.$lang.' as bank_name',
        //     'BuyerCashOutRequest.account_holder',
        //     'BuyerCashOutRequest.account_number',
        //     'BuyerCashOutRequest.created_at',
        //     'BuyerCashOutRequest.status'
        // ];
        $items = BuyerCashOutRequest::leftJoin('Bank as B', 'B.seq', '=', 'BuyerCashOutRequest.bank')
        ->leftJoin('Buyer', 'Buyer.seq', '=', 'BuyerCashOutRequest.buyer')
        ->where('Buyer.seq', $seq);
        // if ($status != '' && $status != null) {
        //     $items = $items->where('BuyerCashOutRequest.status', $status);
        // }
        $recordsTotal = $items->count();
        if (!empty($searchValue)) {
            $items = $items->where(function ($query) use ($searchValue) {
                $query
                ->where('BuyerCashOutRequest.amount', 'like', '%'.$searchValue.'%')
                ->orWhere('Buyer.id', 'like', '%'.$searchValue.'%')
                // ->orWhere('B.name_'.$lang, 'like', '%'.$searchValue.'%')
                ->orWhere('BuyerCashOutRequest.account_holder', 'like', '%'.$searchValue.'%')
                ->orWhere('BuyerCashOutRequest.account_number', 'like', '%'.$searchValue.'%');
            });
        }
        $recordsFiltered = $items->count();

        $items = $items->select(
            'BuyerCashOutRequest.amount',
            'Buyer.id',
            'B.name_'.$lang.' as bank_name',
            'BuyerCashOutRequest.account_holder',
            'BuyerCashOutRequest.account_number',
            'BuyerCashOutRequest.created_at',
            'BuyerCashOutRequest.status',
            'BuyerCashOutRequest.seq'
        )
        // ->orderBy($columnArray[$orderColumnsNo], $orderType)
        ->offset($page)
        ->limit($limit)
        ->get();

        $return['data'] = $buyer;
        $return['count'] = $recordsTotal;
        return $this->responseOK('success', $return);
    }
    public function showBuyerInfo(Request $request)
    {
        // $seq = $request->session()->get('buyer.seq');
        // $lang = $request->session()->get('bw.locale');
        $seq=14;
        $buyer = Buyer::where('seq',$seq)->select('bank','bank_account_owner','bank_account','point')->first();
        $lang='zh';
        if(!$buyer){
            return $this->responseNotFound('can not find the buyer', 401);//error code 404,401
        }

        if (!$buyer->bank || !$buyer->bank_account_owner || !$buyer->bank_account) {
            return $this->responseBadRequest('there is no bank information', 401);//error code 400,401
        } 
       $bankName = Bank::select('name_'.$lang.' as bank_name')->where('name_'.$lang,'!=',null)->where('seq', $buyer->bank)->first();
       $buyer['bankName']=$bankName['bank_name'];
       return $this->responseOK('success', $buyer);

    }
   
    public function requestCash(Request $request)
    {
        // $seq = $request->session()->get('buyer.seq');
        // $lang = $request->session()->get('bw.locale');
        $seq=14;
        $lang='zh';
        $input = Input::only([  
            'modal_amount'
            ]
        );
        $buyer = Buyer::find($seq);
        $bankName = Bank::select('name_'.$lang.' as bank_name')->where('name_'.$lang,'!=',null)->where('seq', $buyer->bank)->first();
        $amount = intval($request->input('modal_amount'));
        if(empty($buyer)){
            return $this->responseNotFound('no buyer');
        }

        if (intval($request->input('modal_amount')) < 20000) {
            return $this->responseNotFound("提现金额不能低于20000");
        }

        if (intval($request->input('modal_amount')) > intval($buyer['point'])) {
            return $this->responseNotFound("喜豆点不足");
        }
       
        $buyerPoint = BuyerPoint::create([
            'io'             => 'out',
            'type'           => 'Cash Out Request',
            'point'          => $amount,
            'signed_point'   => 0 - $amount,
            'remain_point'   => $buyer->point - $amount,
            'status'         => 'registered',
            'buyer'          => $buyer->seq
        ]);

        $buyer->point = $buyer->point - $amount;
        $buyer->total_point_out = $buyer->total_point_out + $amount;
        $buyer->save();

        $cashoutRequest = BuyerCashOutRequest::create([
            'amount'          => $amount,
            'bank_name'       => $bankName->bank_name,
            'account_holder'  => $buyer->bank_account_owner,
            'account_number'  => $buyer->bank_account,
            'status'          => 'requested',
            'buyer'           => $buyer->seq,
            'bank'            => $buyer->bank,
            'buyer_point'     => $buyerPoint->seq
        ]);

        return $this->responseOK('Cash out request success', $cashoutRequest);
    }
}
