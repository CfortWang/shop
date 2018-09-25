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
    public function __construct()
    {
    }
    public function scannedUserList(Request $request){
    
        // $buyer = $request->session()->get('buyer.seq');
        $buyer=2;
        $items = DB::table('UserScanLog')
                    ->where('UserScanLog.buyer',$buyer)  
                    // ->join('User','User.seq','=','UserScanLog.user')  
                    ->select(  
                        'UserScanLog.user',
                         DB::raw('count(UserScanLog.user) AS scannedCount'))  
                    ->groupBy('UserScanLog.user')  
                    ->get();  
        foreach($items as $k=>$v){
            $user=User::where('seq',$v->user)->select('nickname','gender')->first();
            $firstTime=UserScanLog::where('user',$v->user)->where('buyer',$buyer)->select('created_at')->orderBy('created_at','asc')->first();
            $endTime=UserScanLog::where('user',$v->user)->where('buyer',$buyer)->select('created_at')->orderBy('created_at','desc')->first();
            $list['nickname']=$user['nickname'];
            $list['gender']=$user['gender'];
            $list['scannedCount']=$v->scannedCount;
            $list['firstTime']= $firstTime['created_at'];
            $list['endTime']=$endTime['created_at'];
            $list['user']=$v->user;
            $data[]=$list;
        }
        
        // $items = $items->select('user_phone_num', 'user_name','created_at','q35code_code','q35package_code')
        //         ->orderBy()
        //         ->offset($offset)
        //         ->limit($limit)
        //         ->get();
        return $this->response4DataTables($data, 1, 1);
    }
    public function scannedUserDetail(Request $request, $seq)
    {
       // $buyer = $request->session()->get('buyer.seq');
        $buyer=2;
        $input = Input::only('seq');
        $validator = Validator::make($input, [
            'seq'           => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseBadRequest('Bad Request');
        }
        $seq=$request->input('seq');
        dd($seq);
        $veriSeq=UserScanLog::where('buyer',$buyer)->where('user',$seq)->select('created_at')->get()->toArray();
        if(empty($veriSeq)){
            return $this->responseBadRequest('seq is error');  
        }
        $user=User::where('seq',$seq)->select("nickname",'id')->first();
        foreach($veriSeq as $k=>$v){
           $data['id']=$user['id'];
           $data['nickname']=$user['nickname'];
           $data['created_at']=$v['created_at'];
           $items[]=$data;
        }
        return $this->responseOk($items);
    }
    //拼豆豆中用户
    public function pddIngUserList(Request $request){
        // $buyer=$request->session()->get('buyer.seq'); 
        $buyer=39;
        $items=GrouponRecord::where('p.buyer_id',$buyer)
                      ->where('g.groupon_status',1)
                      ->leftJoin('groupon as g','g.id','=','groupon_record.groupon_id')
                      ->leftJoin('groupon_product as p','p.id','=','g.groupon_product_id')
                      ->leftJoin('User as u','u.seq','=','groupon_record.user_id')
                      ->select('u.id','u.nickname','groupon_record.is_owner','g.groupon_status','g.created_at')
                      ->get();
        return $this->response4DataTables($items, 1, 1);
    }
     //拼豆豆成功用户
     public function pddSuccessUserList(Request $request){
        // $buyer=$request->session()->get('buyer.seq'); 
        $buyer=39;
        $items=GrouponRecord::where('p.buyer_id',$buyer)
                      ->where('g.groupon_status',2)
                      ->leftJoin('groupon as g','g.id','=','groupon_record.groupon_id')
                      ->leftJoin('groupon_product as p','p.id','=','g.groupon_product_id')
                      ->leftJoin('User as u','u.seq','=','groupon_record.user_id')
                      ->select('u.id','u.nickname','groupon_record.is_owner','g.groupon_status','g.created_at','g.updated_at')
                      ->get();
        return $this->response4DataTables($items, 1, 1);
    }
     //拼豆豆失败用户
     public function pddFailUserList(Request $request){
        // $buyer=$request->session()->get('buyer.seq'); 
        $buyer=39;
        $items=GrouponRecord::where('p.buyer_id',$buyer)
                      ->where('g.groupon_status',3)
                      ->leftJoin('groupon as g','g.id','=','groupon_record.groupon_id')
                      ->leftJoin('groupon_product as p','p.id','=','g.groupon_product_id')
                      ->leftJoin('User as u','u.seq','=','groupon_record.user_id')
                      ->select('u.id','u.nickname','groupon_record.is_owner','g.groupon_status','g.created_at','g.updated_at')
                      ->get();
        return $this->response4DataTables($items, 1, 1);
    }
    //领取优惠券用户
    public function couponUserList(Request $request){
        // $buyer=$request->session()->get('buyer.seq');
        $buyer=1;
        $items=ShopEventCoupon::where('ShopEventCoupon.buyer',$buyer)
        ->leftJoin('ShopGift as g','g.seq','=','ShopEventCoupon.shop_gift')
        ->select('g.name','ShopEventCoupon.created_at','ShopEventCoupon.status','ShopEventCoupon.used_at','ShopEventCoupon.status')
        ->get();
        return $this->responseOK($items);
    }
}
