<?php

namespace App\Http\Controllers\Api;

use Validator;
use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Helpers\FileHelper;
use App\Models\Q35Sales;
use App\Models\Q35Package;
use App\Models\Q35SingleCode;
use App\Models\SalesPartner;
use App\Models\PartnerAccount;
use App\Models\Q35SalesItem;
use App\Models\BuyingRequest;
use App\Models\Buyer;
use App\Models\Shop2Q35Package;
use App\Models\ShopCategory;
use App\Models\ShopDetailImage;
use App\Models\ShopImageFile;
use App\Models\ShopCoupon;
use App\Models\ShopCouponRecord;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->buyer_id = 14;
    }

    public function info(Request $request){
        $seq = $request->session()->get('buyer.seq');
        $buyer = $this->buyer_id;
        $items = Buyer::where('Buyer.seq',$buyer) 
                    ->leftJoin('ShopImageFile as F','F.seq', '=', 'Buyer.shop_logo_image_file')
                    ->select('Buyer.name as shop_name','Buyer.phone_num',
                    'Buyer.open_time','Buyer.close_time','Buyer.province','Buyer.city','Buyer.area','Buyer.address_detail','F.url','Buyer.lat','Buyer.lng')
                    ->first();
        $data=ShopDetailImage:: where('buyer',$buyer)
                    ->leftJoin('ShopImageFile as F','F.seq', '=', 'ShopDetailImage.shop_image_file')
                    ->select('ShopDetailImage.order_num','ShopDetailImage.seq',
                    'F.url')
                    ->orderBy('ShopDetailImage.order_num','desc')
                    ->get();
        $items['detailImage']=$data;
        if(empty($items)){
            return $this->responseNotFound('No data','');
        }
        return $this->responseOK('Ok',$items);
    }

    public function category(Request $request){
        $lang = $request->session()->get('bw.locale');
        $lang="zh";
        $data = ShopCategory::select('seq', 'name_'.$lang.' as name')->orderBy('seq', 'asc')->get();
        return $this->responseOK('Ok',$data);
    }

    public function modify(Request $request){
        $seq = $request->session()->get('buyer.seq');
        $input = Input::only([
            'name',
            'buyer_category',
            'phone_num',
            'open_time',
            'close_time',
            'country',
            'province',
            'city',
            'area',
            'address_detail',
            'lat',
            'lng',
            'cropped_logo_image',
            'cropped_detail_image_1',
            'cropped_detail_image_2',
            'cropped_detail_image_3',
            'cropped_detail_image_4',
            'cropped_detail_image_5'
        ]);

        $validator = Validator::make($input,[
            'name'                   => 'required|string|min:1',
            'buyer_category'         => 'nullable|integer|min:1',
            'phone_num'              => 'required|string',
            'open_time'              => 'nullable|string',
            'close_time'             => 'nullable|string',
            'country'                => 'required|integer|min:1',
            'province'               => 'required|integer|min:1',
            'city'                   => 'nullable|integer|min:1',
            'area'                   => 'nullable|integer|min:1',
            'address_detail'         => 'nullable|string',
            'lat'                    => 'required|numeric',
            'lng'                    => 'required|numeric',
            'cropped_logo_image'     => 'nullable',
            'cropped_detail_image_1' => 'nullable',
            'cropped_detail_image_2' => 'nullable',
            'cropped_detail_image_3' => 'nullable',
            'cropped_detail_image_4' => 'nullable',
            'cropped_detail_image_5' => 'nullable'
        ]);
        if ($validator->fails()) {
            return $this->responseBadRequest('parameter is invalid', 401);//error code 400,401
        }

        $Buyer = Buyer::where('seq', $seq)->first();

        if (empty($Buyer)){
            return $this->responseNotFound('There is no buyer', 401);//error code 404,401
        }
        $logo = $request->file('cropped_logo_image');
        if($logo){
            // list($imageWidth, $imageHeight) = getimagesize($logo);
            // if ($imageWidth ! ==  180 || $imageHeight ! ==  180) {
            //     return $this->responseBadRequest('Wrong Image size', 402);//error code 400,402
            // }
            $shopLogoImage = FileHelper::shopLogoImage($logo);
            $shopLogoImage = ShopImageFile::create($shopLogoImage);
            $Buyer->shop_logo_image_file = $shopLogoImage->seq;
        }
        $detailImage1 = $request->file('cropped_detail_image_1');
        $detailImage2 = $request->file('cropped_detail_image_2');
        $detailImage3 = $request->file('cropped_detail_image_3');
        $detailImage4 = $request->file('cropped_detail_image_4');
        $detailImage5 = $request->file('cropped_detail_image_5');
        if($detailImage1){
            $oldShopDetailImage = ShopDetailImage::where('buyer', $Buyer->seq)
            ->where('order_num', 1)
            ->delete();
            $shopDetailImage = FileHelper::shopDetailImage($detailImage1);
            $shopDetailImage = ShopImageFile::create($shopDetailImage);
            ShopDetailImage::create([
                'type'             => 'event',
                'order_num'        => 1,
                'buyer'            => $Buyer->seq,
                'shop_image_file'  => $shopDetailImage->seq
            ]);
        }
        if($detailImage2){
            $oldShopDetailImage = ShopDetailImage::where('buyer', $Buyer->seq)
            ->where('order_num', 2)
            ->delete();
            $shopDetailImage = FileHelper::shopDetailImage($detailImage2);
            $shopDetailImage = ShopImageFile::create($shopDetailImage);
            ShopDetailImage::create([
                'type'             => 'event',
                'order_num'        => 2,
                'buyer'            => $Buyer->seq,
                'shop_image_file'  => $shopDetailImage->seq
            ]);
        }
        if($detailImage3){
            $oldShopDetailImage = ShopDetailImage::where('buyer', $Buyer->seq)
            ->where('order_num', 3)
            ->delete();
            $shopDetailImage = FileHelper::shopDetailImage($detailImage3);
            $shopDetailImage = ShopImageFile::create($shopDetailImage);
            ShopDetailImage::create([
                'type'             => 'event',
                'order_num'        => 3,
                'buyer'            => $Buyer->seq,
                'shop_image_file'  => $shopDetailImage->seq
            ]);
        }
        if($detailImage4){
            $oldShopDetailImage = ShopDetailImage::where('buyer', $Buyer->seq)
            ->where('order_num', 4)
            ->delete();
            $shopDetailImage = FileHelper::shopDetailImage($detailImage4);
            $shopDetailImage = ShopImageFile::create($shopDetailImage);
            ShopDetailImage::create([
                'type'             => 'event',
                'order_num'        => 4,
                'buyer'            => $Buyer->seq,
                'shop_image_file'  => $shopDetailImage->seq
            ]);
        }
        if($detailImage5){
            $oldShopDetailImage = ShopDetailImage::where('buyer', $Buyer->seq)
            ->where('order_num', 5)
            ->delete();
            $shopDetailImage = FileHelper::shopDetailImage($detailImage5);
            $shopDetailImage = ShopImageFile::create($shopDetailImage);
            ShopDetailImage::create([
                'type'             => 'event',
                'order_num'        => 5,
                'buyer'            => $Buyer->seq,
                'shop_image_file'  => $shopDetailImage->seq
            ]);
        }
        // else if(!$Buyer->shop_logo_image_file){
        //     return $this->responseBadRequest('Upload logo first', 403);//error code 400,403
        // }

        $Buyer->name = $input['name'];
        $Buyer->branch_name = $input['branch_name'];
        $Buyer->buyer_category = $input['buyer_category'];
        $Buyer->phone_num = $input['phone_num'];
        $Buyer->homepage_url = $input['homepage_url'];
        $Buyer->open_time = $input['open_time'];
        $Buyer->close_time = $input['close_time'];
        $Buyer->open_close_remark = $input['time_remark'];
        $Buyer->country = $input['country'];
        $Buyer->province = $input['province'];
        $Buyer->city = $input['city'];
        $Buyer->area = $input['area'];
        $Buyer->address_detail = $input['address_detail'];
        $Buyer->description = $input['description'];
        $Buyer->lat = $input['lat'];
        $Buyer->lng = $input['lng'];
        $Buyer->save();
        return $this->responseOK('success','');
    }

    public function deleteImage(Request $request)
    {
        $buyer = $request->session()->get('buyer.seq');
        $buyer = $this->buyer_id;
        $input = Input::only([
            'image_type',
            'detailSeq'
        ]);
        $validator = Validator::make($input,[
            'image_type'             => 'required|string|min:1',
            'detailSeq'              => 'nullable'
        ]);
        if ($validator->fails()) {
            return $this->responseBadRequest('parameter is invalid', 401);//error code 400,401
        }
        $Buyer = Buyer::where('seq', $buyer)->first();
        if (empty($Buyer)){
            return $this->responseNotFound('There is no buyer', 401);//error code 404,401
        }
        $imageType = $input['image_type'];
        $detailSeq = $input['detailSeq'];
        $exitDetailImage=ShopDetailImage::where('seq',$detailSeq)->where('buyer',$buyer)->first();
        if(empty($exitDetailImage)){
            return $this->responseNotFound('There is no detailSeq', 401);//error code 404,401
        }
        if ($imageType  == 'shop_logo') {
            $Buyer->shop_logo_image_file = null;
            $Buyer->save();
        } else if ($imageType  == 'shop_detail') {
            ShopDetailImage::where('buyer', $buyer)
                ->where('seq',$input['detailSeq'] )
                ->delete();
        } 

        return $this->responseOK('success','');
    }
    public function createCoupon(Request $request){
        $buyer = $this->buyer_id;
        $input=Input::only('coupon_name','quantity','coupon_type','discount_money','discount_percent',
                          'max_discount_money','limit_type','limit_money','image','limit_count','coupon_date_type','start_at','expired_at','days',
                          'available_time_type', 'available_time','business_hours','is_special_goods','pkgList','condition','goods_name','remark','is_festival','is_weekend');
         $message = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
            "integer" => ":attribute ".trans('common.createCoupon.verification.requiredNumber'),
        ];
        $validator = Validator::make($input,[
            'coupon_name'             => 'required|string',
            'quantity'                => 'required|integer|min:1|max:1000000',
            'coupon_type'             => 'required|in:0,1',
            'discount_money'          => 'nullable|numeric|min:0.01',
            'discount_percent'        => 'nullable|numeric',
            'max_discount_money'      => 'nullable|numeric',
            'limit_type'              => 'required|in:0,1',
            'limit_money'             => 'nullable|numeric',
            'image'                   => 'required|string',
            'limit_count'             => 'required|integer',
            'coupon_date_type'        => 'required|in:0,1',
            'start_at'                => 'nullable|date',
            'expired_at'              => 'nullable|date',
            'days'                    => 'nullable|integer',
            'available_time_type'     => 'required|in:0,1',
            'available_time'          => 'nullable|array',
            'business_hours'          => 'nullable|string',
            'condition'               => 'nullable|string',
            'is_special_goods'        => 'required|in:0,1',
            'goods_name'              => 'nullable|string',
            'remark'                  => 'nullable',
            'pkgList'                 => 'nullable',
            'is_festival'             => 'nullable|in:0,1',
            'is_weekend'              => 'nullable|in:0,1',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }       
        $couponName = $request->input('coupon_name');
        $quantity = $request->input('quantity');
        $couponType = $request->input('coupon_type');
        $discountMoney = $request->input('discount_money');
        $discountPercent = $request->input('discount_percent');
        $maxDiscountMoney = $request->input('max_discount_money');
        $limitMoney = $request->input('limit_money');
        $limitType = $request->input('limit_type');
        $image = $request->input('image');
        $limitCount = $request->input('limit_count');
        $couponDateType = $request->input('coupon_date_type');
        $startAt = $request->input('start_at');
        $expiredAt = $request->input('expired_at');
        $days = $request->input('days');
        $availableTimeType = $request->input('available_time_type');
        $availableTime = $request->input('available_time');
        $businessHours = $request->input('business_hours');
        $condition = $request->input('condition');
        $isSpecialGoods = $request->input('is_special_goods');
        $goodsName = $request->input('goods_name');
        $remark = $request->input('remark');
        $is_festival = $request->input('is_festival');
        $is_weekend = $request->input('is_weekend');
        //验证优惠类型
        if($couponType == 0){
             //面值
            if(empty($discountMoney)){
                return $this->responseNotFound(trans('shop.verification.emptyDiscountMoney'));
            }
        }
        if($couponType == 1){
             //折扣率
            if(empty($discountPercent)){
                return $this->responseNotFound(trans('shop.verification.emptyDiscountPercent'));
            }
            //最大优惠
            if(empty($maxDiscountMoney)){
                return $this->responseNotFound(trans('shop.verification.emptyMaxDiscountMoney'));
           }
           if($discountPercent<1 || $discountPercent>9.9){
            return $this->responseNotFound(trans('shop.verification.discountPercentError'));
           }
        }
        //验证使用门槛类型
        if($limitType == 0){
            $limitMoney=0;
        }
        if($limitType == 1){
            if(empty($limitMoney)){
                return $this->responseNotFound(trans('shop.verification.emptyLimitMoney'));
            }
            if($limitMoney <= 0){
                return $this->responseNotFound(trans('shop.verification.limitMoneyError'));
            }
        }
        //验证优惠券有效期
        if( $couponDateType == 0){
           if(empty($startAt)){
                return $this->responseNotFound(trans('shop.verification.emptyStartAt'));
            }
            if(empty($expiredAt)){
                return $this->responseNotFound(trans('shop.verification.emptyExpiredAt'));
            }
            if($startAt >= $expiredAt){
                return $this->responseNotFound(trans('shop.verification.timeError'));
            }
        }
        if($couponDateType == 1){
            dd(1);
            if(empty($days)){
                return $this->responseNotFound(trans('shop.verification.emptyDays'));
            }  
            if($days<1 || $days>365){
                return $this->responseNotFound(trans('shop.verification.daysError'));
            }   
        }
        //验证有效时间段
        if ($availableTimeType == 0){
            $availableTime=0;
         }
        if ($availableTimeType == 1){
             if(empty($availableTime)){
                return $this->responseNotFound(trans('shop.verification.emptyAvailableTime'));
             }else{
                $availableTime = implode('',$availableTime);
             }
            //  if(empty($businessHours)){
            //     return $this->responseNotFound(trans('shop.verification.emptyBusinessHours'));
            //  }
         }
        //验证优惠使用条件
        if ( $isSpecialGoods == 1){
            if(empty($goodsName)){
                return $this->responseNotFound(trans('shop.verification.emptyGoodsName'));
             }
         }
        
       
        $data = ShopCoupon::create([
            'coupon_name'            => $couponName,
            'quantity'               => $quantity,
            'coupon_type'            => $couponType,
            'discount_money'         => $discountMoney,
            'discount_percent'       => $discountPercent,
            'max_discount_money'     => $maxDiscountMoney,
            'image'                  => $image,
            'limit_money'            => $limitMoney,
            'limit_count'            => $limitCount,
            'start_at'               => $startAt,
            'expired_at'             => $expiredAt,
            'days'                   => $days,
            'available_time'         => $availableTime,
            'business_hours'         => $businessHours,
            'condition'              => $condition,
            'is_special_goods'       => $isSpecialGoods,
            'goods_name'             => $goodsName,
            'remark'                 => $remark,
            'status'                 => 'registered',
            'buyer_id'               => $buyer,
            'is_weekend'             => $is_weekend,
            'is_festival'            => $is_festival,
        ]);
        $pkgSeqList = $request->input('pkgList');
        if($pkgSeqList){
            $packages = Q35Package::whereIn('seq', $pkgSeqList)->select('start_q35code','end_q35code','seq')->get();
            if($packages){
                foreach($packages as $k1=>$v1){
                    Shop2Q35Package::create([
                        'type'             => 'coupon',
                        'start_num'        => $v1['start_q35code'],
                        'end_num'          => $v1['end_q35code'],
                        'status'           => 'registered',
                        'buyer'            => $buyer,
                        'shop_coupon'      => $data->id,
                        'q35package'       => $v1['seq']
                    ]);
                }
            }
        }
        return $this->responseOk('',$data);
    }
    public function couponList(Request $request){
        $buyer = $this->buyer_id;
        $limit = $request->input('limit');
        $page = $request->input('page');
        $valueName= $request->input('coupon_name');
        $valueStatus= $request->input('status');
        $items=ShopCoupon::where('buyer_id',$buyer);
        if($valueName){
           $items=$items->where('coupon_name', 'like', '%'.$valueName.'%');             
        }
        if($valueStatus){
            $items=$items->where('status', $valueStatus);           
         }
        $count=$items->orderBy('id','desc')->get();
        $count=count($count);
        $items=$items->orderBy('id','desc')->limit($limit)->offset(($page-1)*$limit)->get();
        $length=count($items);
        if ( $length == 0){
            return $this->responseNotFound('no data');
        }
        foreach($items as $k=>$v){
            $data['id']=$v['id'];
            $data['coupon_name']=$v['coupon_name'];
            $discountMoney=$v['discount_money'];
            $discountPercent=$v['discount_percent'];
            if($v['coupon_type'] == '0'){
                $data['value']="￥$discountMoney";
            }else{
                $data['value']=$discountPercent .'折';
            }
            $data['limit_money']=$v['limit_money'];
            if($v['limit_money'] == 0){
                $data['limit_money']='';
            }
            $used=ShopCouponRecord::where('shop_coupon_id',$v['id'])->where('buyer_id',$buyer)->where('status','used')->get();
            $receive=ShopCouponRecord::where('shop_coupon_id',$v['id'])->where('buyer_id',$buyer)->get();
            //已领取数量
            $receiveCount=count($receive);
            if(empty($receiveCount)){
                $data['receiveCount']="";
            }else{
                $data['receiveCount']=$receiveCount;
            }
            //领取人数
            $peopleCount=DB::table('shop_coupon_record')
                ->select(DB::raw('count(shop_coupon_record.user_id) AS userCount'))
                ->groupBy('shop_coupon_record.user_id')
                ->where('shop_coupon_record.shop_coupon_id',$v['id'])
                ->first();
            if(isset($peopleCount->userCount)&&$peopleCount->userCount){
                $data['peopleCount']=$peopleCount->userCount;
            }else{
                $data['peopleCount']="";
            }
            //领取限制
            $limitCount=$v['limit_count'];
            if($v['limit_count'] == 0){
                $data['limit_count']="不限张数";
            }else{
                $data['limit_count']="一人 $limitCount 张";
            }
            $data['usedCount']=count($used);
            //库存
            $data['reserve']=$v['quantity']-count($used);
            //有效期
            $days=$v['days'];
            $startAt=$v['start_at'];
            $expiredAt=$v['expired_at'];
            if(empty($v['days'])){
                $data['period_time']=$startAt.'至'.$expiredAt;
            }else{
                $data['period_time']="领券次日开始 $days 天内有效"; 
            }
            $data['receiving_rate']=($receiveCount / $v['quantity'])* 100 ."%";
            $data['used_rate']=($receiveCount / $v['quantity'])* 100 ."%";
            if(empty($data['usedCount'])){
                $data['usedCount']="--";
                $data['used_rate']="--";
            }
            if(empty($receiveCount)){
                $data['receiving_rate']="--";
            }
            $data['statusValue']=$v['status'];
            if($v['status'] == 'registered'){
                $data['status']="未开始";
            }
            if($v['status'] == 'processed'){
                $data['status']="进行中";
            }
            if($v['status'] == 'overed'){
                $data['status']="已结束";
            }
            $list[] = $data;
        }
        
        $newData['count'] = $count;
        $newData['data'] = $list;
        return $this->responseOk('',$newData);
    }
    public function couponStatus(Request $request)
    {
        $buyer_id = 14;
        $input=Input::only('id','status');
        $message = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        ];
        $validator = Validator::make($input, [
            'id'                => 'required|numeric',
            'status'                => 'required|in:registered,processed',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }
        $id = $input['id'];
        $status = $input['status'];
        $shopCoupon = ShopCoupon::where('id',$id)->where('buyer_id',$buyer_id)->first();
        if(empty($shopCoupon)){
            return $this->responseBadRequest('id is error',401);
        }
        if($status == 'processed'){
            $shopCoupon->status="registered";
        }else{
            $shopCoupon->status="processed";
        }
        $shopCoupon->save();
        return $this->responseOk('',$shopCoupon);
    }
    public function deleteCoupon(Request $request){
        $id = $request->input('id');
        $shopCoupon=ShopCoupon::where('id',$id)->first();
        if(empty($shopCoupon)){
            return $this->responseBadRequest('id is error');
        }
        $shopCoupon->delete();
        return $this->responseOk('删除成功');
    }
    public function detail(Request $request)
    {
        // $buyer = $request->session()->get('buyer.seq');
        $buyer = $this->buyer_id;
        $id = $request->input('id');
        $item = ShopCoupon::where('shop_coupon.id',$id)->where('buyer_id',$buyer)->first();
        if(empty($item)){
            return $this->responseNotFound('id is error');
        }  
        $pkgList=Shop2Q35Package::where('buyer',$buyer)->where('shop_coupon',$id)
                                ->leftJoin('Q35Package as P','P.seq', '=', 'Shop2Q35Package.q35package')
                                ->select('P.code','P.seq')
                                ->get();
        $item['pkgList']=$pkgList;
        return $this->responseOk('', $item);
    }
    public function statusList(Request $requst){
        $data=array(
            0=>array('status'=>"processed",'value'=>'进行中'),  
            1=>array('status'=>"registered",'value'=>'未开始'),  
            2=>array('status'=>"overed",'value'=>'已结束'),  
        );
        // $k['v1']['status']="processed";
        // $k['v1']['value']="进行中";
        // $k['v2']['status']="registered";
        // $k['v2']['value']="未开始";
        // $k['v3']['status']="overed";
        // $k['v3']['value']="已结束";
        return $this->responseOk('', $data);
    }
    public function modifyCoupon(Request $request){
        $input=Input::only('coupon_name','quantity','coupon_type','discount_money','discount_percent',
                          'max_discount_money','limit_type','limit_money','image','limit_count','coupon_date_type','start_at','expired_at','days',
                          'available_time_type',  'available_time','business_hours','is_special_goods','pkgList','condition','goods_name','remark');
         $message = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
            "integer" => ":attribute ".trans('common.createCoupon.verification.requiredNumber'),
        ];
        $validator = Validator::make($input,[
            'coupon_name'             => 'required|string',
            'quantity'                => 'required|integer|min:1|max:1000000',
            'coupon_type'             => 'required|in:0,1',
            'discount_money'          => 'nullable|numeric|min:0.01',
            'discount_percent'        => 'nullable|numeric',
            'max_discount_money'      => 'nullable|numeric',
            'limit_type'              => 'required|in:0,1',
            'limit_money'             => 'nullable|numeric',
            'image'                   => 'required|image',
            'limit_count'             => 'required|integer',
            'coupon_date_type'        => 'required|in:0,1',
            'start_at'                => 'nullable|date',
            'expired_at'              => 'nullable|date',
            'days'                    => 'nullable|integer',
            'available_time_type'     => 'required|in:0,1',
            'available_time'          => 'nullable|string',
            'business_hours'          => 'nullable|string',
            'condition'               => 'nullable|string',
            'is_special_goods'        => 'required|in:0,1',
            'goods_name'              => 'nullable|string',
            'remark'                  => 'nullable',
            'pkgList'                 => 'nullable',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }  
    }
}
