<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileHelper;

use App\Models\ShopAD;
use App\Models\Q35Package;
use App\Models\Q35Sales;
use App\Models\ShopImageFile;
use App\Models\Shop2Q35Package;
use Illuminate\Support\Carbon;
use App\Helpers\ParamValidationHelper;


class AdController extends Controller
{
   
    public function adList(Request $request)
    {
        // $seq = $request->session()->get('buyer.seq');
        // $input=Input::only('limit','page');
        $seq=14;
        $limit = $request->input('limit');
        $page = $request->input('page');
        $count = ShopAD::where('buyer',$seq)->get();
        $count=count($count);
        $items = ShopAD::where('buyer',$seq)->select('title', 'view_cnt', 'start_date','end_date', 'status', 'seq')
                ->orderBy('seq','asc')
                ->limit($limit)
                ->offset(($page-1)*$limit) 
                ->get(); 
        foreach($items as $k=>$v){
            $startDate=Carbon::parse($v['start_date'])->toDateTimeString();
            $startDate=strtotime($startDate);
            $endDate=Carbon::parse($v['end_date'])->toDateTimeString();
            $endDate=strtotime($endDate);
            $day=floor(($endDate-$startDate)/3600/24);
            $list['seq']=$v['seq'];
            if($v['status']=="registered" || $v['status']=="stopped"){
                $list['status']=1;
            }elseif($v['status']=="activated"){
                $list['status']=0;
            }
            $list['title']=$v['title'];
            $list['view_cnt']=$v['view_cnt'];
            $list['start_date']=$v['start_date'];
            $list['day']=$day;
            $newData[]=$list;

        }
        $data['count']=$count;
        $data['data']=$newData;
        return $this->responseOK('',$data);
    }
    //广告上下架
    public function adStatus(Request $request){
        $buyer=14;
        $Input=Input::only('seq','status');
        // $validator = Validator::make(['seq' => $seq,'status'=>$status],[
        //     'status'  ='requried|in:registered,activated,stopped',
        //     'seq'   => 'requried|integer',
        // ]);
        $message = array(
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
            "integer" => ":attribute ".trans('common.verification.requiredNumber'),
        );
        $validator = Validator::make($Input, [
            'seq'           => 'required|integer',
            'status'           => 'required|in:0,1',
        
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }  
        $seq=$request->input('seq');
        $type=$request->input('status');
        $ShopAd=ShopAd::where('seq',$seq)->where('buyer',$buyer)->first();
        if(empty($ShopAd)){
           return $this->responseBadRequest('seq is error');
        }
        if($type == 0){
         $ShopAd->status="stopped";
        }else{
         $ShopAd->status="activated"; 
        }
        $ShopAd->save();
        return $this->responseOk('', $ShopAd);
    }
    public function detail(Request $request, $seq)
    {
        $buyer = $request->session()->get('buyer.seq');

        $validator = Validator::make(['seq' => $seq],[
            'seq'  => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('id wrong.');
        }

        $item = ShopAD::where('ShopAD.seq',$seq)->where('buyer',$buyer)
                        ->leftJoin('ShopImageFile as F','F.seq', '=', 'ShopAD.shop_image_file')
                        ->select('ShopAD.seq', 'ShopAD.title','ShopAD.type' ,'ShopAD.landing_url','ShopAD.status','F.full_path as shop_image_file')
                        ->first();
        $mediaHost = Config::get('bw.media.host');
        $item->mediaHost = $mediaHost;
        
        if(empty($item)){
            return $this->responseNotFound('No data','','');
        }
        return $this->responseOk('', $item);
    }
    public function createAd(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $buyer=14;
        $input = Input::only('title', 'landing_url' , 'ad_image_file','start_date','end_date', 'pkg_list');
        $message = array(
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
            "integer" => ":attribute ".trans('common.verification.requiredNumber'),
        );
        $validator = Validator::make($input, [
            'title'           => 'required|string|min:1',
            'ad_image_file'   => 'required|image',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date',
            'landing_url'     => 'required|string',
            'pkg_list'        => 'nullable'
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }  
        $title = $request->input('title');
        $landingUrl = $request->input('landing_url');
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        if($start_date >= $end_date){
            return $this->responseBadRequest('结束时间必须大于开始时间');
        }
        $exits = ShopAD::where('buyer', $buyer)->where('title',$title)->first();
        if($exits){
            return $this->responseBadRequest('already exist title', 401);//error code 409,401
        }
        $pkgSeqList = $request->input('pkg_list');
        $pkgSeqList = ParamValidationHelper::isValidSeqListStr($pkgSeqList);
        $image = $request->file('ad_image_file');
        // list($imageWidth, $imageHeight) = getimagesize($image);
        // if ($imageWidth !== 1280 || $imageHeight !== 480) {
        //     return $this->responseBadRequest('Wrong Image size', 402);//error code 400,402
        // }      
        $adImage = FileHelper::shopAdImage($image);
        $adImage = ShopImageFile::create($adImage);
        $shopAd = ShopAD::create([
            'title'            => $input['title'],
            'landing_url'      => $landingUrl,
            'start_date'      => $start_date,
            'end_date'         => $end_date,
            'status'           => 'registered',
            'buyer'            => $buyer,
            'shop_image_file'  => $adImage->seq
        ]);

        if ($pkgSeqList) {
            $packages = Q35Package::whereIn('seq', $pkgSeqList)->get();
            foreach ($packages as $package) {
                Shop2Q35Package::create([
                    'type'             => 'ad',
                    'start_num'        => $package->start_q35code,
                    'end_num'          => $package->end_q35code,
                    'status'           => 'registered',
                    'buyer'            => $buyer,
                    'shop_ad'          => $shopAd->seq,
                    'q35package'       => $package->seq
                ]);
            }
        }
        return $this->responseOK('success', $shopAd);
    }
    //修改广告
    public function modifyAd(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $buyer=14;
        $input = Input::only('seq','title', 'landing_url' , 'ad_image_file', 'pkg_list','start_date','end_date');
        $message = array(
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        );
        $validator = Validator::make($input, [
            'title'           => 'required',
            'ad_image_file'   => 'required|image',
            'landing_url'     => 'required|string',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date',
            'pkg_list'        => 'nullable'
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }   
        $seq=$request->input('seq');
        $ShopAD=ShopAd::where('seq',$seq)->where('buyer',$buyer)->first();
        if(empty($ShopAD)){
           return $this->responseBadRequest('There is no data');
        }
        $start_date=$request->input('start_date');
        $end_date=$request->input('end_date');
        if($start_date >= $end_date){
            return $this->responseBadRequest('结束时间必须大于开始时间');
        }
        $title=$request->input('title');
        $exitTitle=ShopAd::where('title',$title)->first();
        if($exitTitle){
            return $this->responseBadRequest('already exist title', 401);//error code 409,401
        }
       
        $adImage = $request->file('ad_image_file');
        if($adImage){
            // list($imageWidth, $imageHeight) = getimagesize($adImage);
            // if ($imageWidth !== 1280 || $imageHeight !== 480) {
            //     return $this->responseBadRequest('Wrong Image size', 402);//error code 400,402
            // }
            $adImage = FileHelper::shopADImage($adImage);
            $adImage = ShopImageFile::create($adImage);
            $ShopAD->shop_image_file = $adImage->seq;
          
        }else if(!$shopAD->shop_image_file){
            return $this->responseBadRequest('Upload picture first', 403);//error code 400,403
        }
        // $pkgSeqList = $request->input('pkg_list');
        // $pkgSeqList = ParamValidationHelper::isValidSeqListStr($pkgSeqList);
        // $shop2Buyer = Shop2Q35Package::where('shop_ad',$seq)->get();

        // foreach ($shop2Buyer as $item) {
        //     $item->forceDelete();
        // }
        // if ($pkgSeqList) {
        //     $packages = Q35Package::whereIn('seq', $pkgSeqList)->get();

        //     foreach ($packages as $package) {
        //         Shop2Q35Package::create([
        //             'type'             => 'ad',
        //             'start_num'        => $package->start_q35code,
        //             'end_num'          => $package->end_q35code,
        //             'status'           => 'registered',
        //             'buyer'            => $buyer,
        //             'shop_ad'          => $shopAD->seq,
        //             'q35package'       => $package->seq
        //         ]);
        //     }
        // }
        $ShopAD->title = $title;
        $ShopAD->start_date=$start_date;
        $ShopAD->end_date=$end_date;      
        $ShopAD->landing_url = $request->input('landing_url');
        $ShopAD->save();
        return $this->responseOK('success', $ShopAD);
    }
    public function packagelist(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
        $items = Q35Sales::leftJoin('Q35Package as PKG', 'PKG.q35sales', '=', 'Q35Sales.seq')
        ->leftJoin('Shop2Q35Package as S2P', 'S2P.q35package', '=', 'PKG.seq')
        ->where('Q35Sales.buyer', $seq)
        ->where('Q35Sales.pay_status', 'paid')
        ->where('Q35Sales.status', 'completed')
        ->where('PKG.status', 'activated')
        ->where('S2P.seq', '=', null)
        ->select('PKG.seq as pkg_seq', 'PKG.code as pkg_code')
        ->get();

        return $this->responseOk('package list', $items);
    }
    public function allPackagelist(Request $request, $seq)
    {
        $buyer = $request->session()->get('buyer.seq');
        $items = Shop2Q35Package::where('buyer', $buyer)->get();

        $items = Q35Sales::leftJoin('Q35Package as PKG', 'PKG.q35sales', '=', 'Q35Sales.seq')
        ->leftJoin('Shop2Q35Package as S2P', 'S2P.q35package', '=', 'PKG.seq')
        ->where('Q35Sales.buyer', $buyer)
        ->where('Q35Sales.pay_status', 'paid')
        ->where('Q35Sales.status', 'completed')
        ->where('PKG.status', 'activated')
        ->where(function ($query) use ($seq) {
            $query
            ->where('S2P.seq', '=', null)
            ->orWhere('S2P.shop_ad', $seq);
        })
        ->where('S2P.deleted_at', '=', null)
        ->select('PKG.seq as pkg_seq', 'PKG.code as pkg_code', 'S2P.shop_ad as ad_seq')
        ->get();

        return $this->responseOk('package list', $items);
    }
    public function status(Request $request, $status)
    {
        $buyer = $request->session()->get('buyer.seq');
        $input = Input::only('shop_seq');
        $validator = Validator::make($input, [
            'shop_seq'        => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('parameter is invalid', 401);//error 400, 401
        }

        $adSeq = $input['shop_seq'];

        $shopAD = ShopAD::find($adSeq);

        if (empty($shopAD)) {
            return $this->responseNotFound('No data', 401);//error 404, 401
        }

        if ($status === 'activated') {
            $shop2Pkg = Shop2Q35Package::where('shop_ad', $adSeq)->get();
            if (count($shop2Pkg) === 0) {
                return $this->responseNotFound('No Pkg', 402);//error 404, 402
            }
        }

        Shop2Q35Package::where('shop_ad', $adSeq)->update([
            'status'         => $status
        ]);

        $shopAD->status = $status;
        $shopAD->save();

        return $this->responseOK('Ok',$shopAD);
    }
}
