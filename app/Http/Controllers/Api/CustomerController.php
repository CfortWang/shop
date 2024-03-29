<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendCodeHelper;
use Validator;
use Hash;
use App\Models\Buyer;
use App\Models\User;
use App\Models\ShopEventCoupon;
use App\Models\ShopGift;
use App\Models\Groupon;
use App\Models\GrouponProduct;
use App\Models\GrouponRecord;
use App\Models\UserScanLog;
use App\Models\PhoneNumCertification;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function __construct(Request $request)
    {
    }
    //扫描用户列表
    public function scannedUserList(Request $request){
        $buyer = $request->session()->get('buyer.seq');
        $limit = $request->input('limit')?$request->input('limit'):20;
        $page = $request->input('page')?$request->input('page'):1;
        $searchValue = $request->input('phoneNum');
        if($searchValue){
            $items=DB::table('UserScanLog')
                    ->leftJoin('User as u', 'u.seq', '=', 'UserScanLog.user')
                    ->select('u.id','u.nickname','UserScanLog.user','u.gender','u.birthday', DB::raw('count(UserScanLog.user) AS scannedCount'))
                    ->groupBy('UserScanLog.user')
                    ->where('UserScanLog.buyer',$buyer)
                    ->where('u.id', 'like', '%'.$searchValue.'%')
                    ->limit($limit)
                    ->offset(($page-1)*$limit) 
                    ->get();  
        }else{
            $items=DB::table('UserScanLog')
            ->leftJoin('User as u', 'u.seq', '=', 'UserScanLog.user')
            ->select('u.id','u.nickname','UserScanLog.user','u.gender','u.birthday', DB::raw('count(UserScanLog.user) AS scannedCount'))
            ->groupBy('UserScanLog.user')
            ->where('UserScanLog.buyer',$buyer)
            ->limit($limit)
            ->offset(($page-1)*$limit) 
            ->get();
        }
        $count=count($items);
        foreach($items as $k=>$v){
            $firstTime=UserScanLog::where('user',$v->user)->where('buyer',$buyer)->select('created_at')->orderBy('created_at','asc')->first();
            $endTime=UserScanLog::where('user',$v->user)->where('buyer',$buyer)->select('created_at')->orderBy('created_at','desc')->first();
            $list['id']=$v->id;;
            $list['nickname']=$v->nickname;
            $list['gender']=$v->gender;
            if( $list['gender']=='male'){
                $list['gender']='男';
            }
            if( $list['gender']=='female'){
                $list['gender']='女';
            }
            $list['age']=Carbon::parse($v->birthday)->diffInYears();
            $list['rate']= rand(1,9)/10;;
            $list['scannedCount']=$v->scannedCount;
            $list['firstTime']= Carbon::createFromTimestamp(strtotime($firstTime['created_at']))
                                        ->timezone(session('tz'))
                                        ->toDateTimeString();
            $list['endTime']=Carbon::createFromTimestamp(strtotime($endTime['created_at']))
                                        ->timezone(session('tz'))
                                        ->toDateTimeString();
            $list['user']=$v->user;
            $data[]=$list;
        }
        if(empty($data)){
            return $this->responseBadRequest('没有数据');
        }
        $newData['scanUserList']=$data;
        $newData['count']=$count;
        return $this->responseOk('',$newData);
    }
    public function scannedUserDetail(Request $request){
       $buyer = $request->session()->get('buyer.seq');
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $input=Input::only('seq');
        $message = array(
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
            "integer" => ":attribute ".trans('common.verification.requiredNumber'),
        );
        $validator = Validator::make($input, [
            'seq'              => 'required|integer',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        } 
        $seq=$request->input('seq');
        $count=UserScanLog::where('buyer',$buyer)
        ->where('user',$seq)
        ->select('created_at') 
        ->get()->toArray();
        $count=count($count);
        $veriSeq=UserScanLog::where('buyer',$buyer)
                            ->where('user',$seq)
                            ->select('created_at') 
                            ->limit($limit)
                            ->offset(($page-1)*$limit) 
                            ->get()->toArray();
        if(empty($veriSeq)){
            return $this->responseBadRequest('没有数据');  
        }
        $user=User::where('seq',$seq)->select("nickname",'id')->first();
        foreach($veriSeq as $k=>$v){
           $data['id']=$user['id'];
           $data['nickname']=$user['nickname'];
           $data['created_at']=$v['created_at'];
           $items[]=$data;
        }
        $newData['list']=$items;
        $newData['count']=$count;
        return $this->responseOk('',$newData);
    }
    //拼豆豆中用户
    public function pddUserList(Request $request){
        $buyer=$request->session()->get('buyer.seq'); 
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $input=Input::only('type');
        $message = array(
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        );
        $validator = Validator::make($input, [
            'type'              => 'required|in:ing,success,fail',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        } 
        $type=$request->input('type');
        $status = 0;
        if($type == 'ing'){
            $status = 1;
        }
        if($type == 'success'){
            $status = 2;  
        }
        if($type == 'fail'){
            $status = 3;  
        }
        $count=GrouponRecord::where('p.buyer_id',$buyer)
            ->where('g.groupon_status',$status)
            ->leftJoin('groupon as g','g.id','=','groupon_record.groupon_id')
            ->leftJoin('groupon_product as p','p.id','=','g.groupon_product_id')
            ->leftJoin('User as u','u.seq','=','groupon_record.user_id')
            ->select('u.id as phone','u.nickname','groupon_record.is_owner','g.created_at')
            ->get();
        $count=count($count);
        $items=GrouponRecord::where('p.buyer_id',$buyer)
            ->where('g.groupon_status',$status)
            ->leftJoin('groupon as g','g.id','=','groupon_record.groupon_id')
            ->leftJoin('groupon_product as p','p.id','=','g.groupon_product_id')
            ->leftJoin('User as u','u.seq','=','groupon_record.user_id')
             ->select('u.id as phone','u.nickname','groupon_record.is_owner',
                'groupon_record.use_code', 'groupon_record.paid_status','g.created_at','g.updated_at','g.expried_at')
            ->limit($limit)
            ->offset(($page-1)*$limit) 
            ->get();
        $newdata['count']=$count;
        $newdata['data']=$items;
        return $this->responseOk('', $newdata);
    }
     //领取优惠券用户列表
     public function couponUserList(Request $request){
        $buyer=$request->session()->get('buyer.seq');
        // $user=$request->input('user');
        $limit = $request->input('limit',10);
        $page = $request->input('page',1);
        $count  = DB::table('ShopEventCoupon')
                ->where('buyer',$buyer)
                ->where('user','>',0)
                ->select(DB::raw('count(*) as user_count, status,user,created_at'))
                ->groupBy('user')
                ->get();
        $count=count($count);
        $items  = DB::table('ShopEventCoupon')
                     ->where('buyer',$buyer)
                     ->where('user','>',0)
                     ->select(DB::raw('count(*) as user_count, status,user,created_at'))
                     ->groupBy('user')
                     ->limit($limit)
                     ->offset(($page-1)*$limit) 
                     ->get();
        foreach($items as $k=>$v){
            $user=User::where('seq',$v->user)->select('nickname','id')->first();
            $data['user']=$v->user;
            $data['id']=$user['id'];
            $data['nickname']=$user['nickname'];
            $data['user_count']=$v->user_count;
            if($v->user_count > 1){
               $data['status']="";
               $data['use_code']="";
               $data['created_at']="";
               $data['used_at']="";
            }else{
                if($v->status=='used'){
                    $data['status']="已使用"; 
                }else{
                    $data['status']="未使用"; 
                }
                $data['use_code']=rand(1000,9999);
                $data['created_at']=Carbon::parse($v->created_at)->toDateTimeString();
                $data['used_at']="";
            }
            $newdata[]=$data;
        }
        $dataArray['count']=$count;
        $dataArray['data']=$newdata;
        return $this->responseOK('',$dataArray);
    }
    //领取优惠券详细列表
    public function couponDetailUserList(Request $request){
        $buyer=$request->session()->get('buyer.seq');
        $limit = $request->input('limit',10);
        $page = $request->input('page',1);
        $input=Input::only('user');
        $message = array(
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
            "integer" => ":attribute ".trans('common.verification.requiredNumber'),
        );
        $validator = Validator::make($input, [
            'user'              => 'required|integer',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        } 
        $user=$request->input('user');
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $count=ShopEventCoupon::where('ShopEventCoupon.buyer',$buyer)
        ->where('user',$user)
        ->leftJoin('ShopGift as g','g.seq','=','ShopEventCoupon.shop_gift')
        ->select('g.name','ShopEventCoupon.created_at','ShopEventCoupon.status',
        'ShopEventCoupon.used_at')
        ->get();
        $count=count($count);
        $items=ShopEventCoupon::where('ShopEventCoupon.buyer',$buyer)
                            ->where('user',$user)
                            ->leftJoin('ShopGift as g','g.seq','=','ShopEventCoupon.shop_gift')
                            ->select('g.name','ShopEventCoupon.created_at','ShopEventCoupon.status',
                            'ShopEventCoupon.used_at')
                            ->limit($limit)
                            ->offset(($page-1)*$limit) 
                            ->get();
        foreach($items as $k=>$v){
            $data['name']=$v['name'];
            $data['created_at']=Carbon::parse($v['created_at'])->toDateTimeString();
            $data['use_code']=rand(1000,9999);
            if($v['stauts']=='used_at'){
                $data['status']="已使用";
                $data['used_at']=$v['used_at'];
            }else{
                $data['status']="未使用";
                $data['used_at']="";
            }
            $newdata[]=$data;
        }
        $dataArray['count']=$count;
        $dataArray['data']=$newdata;
        return $this->responseOK('',$dataArray);
    }
}
