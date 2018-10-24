<?php

namespace App\Http\Controllers\Api;

use Validator;
use App;
use Carbon\Carbon;

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
    public function __construct(Request $request)
    {
        $this->buyer_id = $request->session()->get('buyer.seq');
    }

    public function info(Request $request){
        $buyer = $this->buyer_id;
        $items = Buyer::where('Buyer.seq',$buyer) 
                    ->leftJoin('ShopImageFile as F','F.seq', '=', 'Buyer.shop_logo_image_file')
                    ->leftJoin('Province as p','p.seq', '=', 'Buyer.province')
                    ->leftJoin('Area as A','A.seq', '=', 'Buyer.area')
                    ->leftJoin('City as C','C.seq', '=', 'Buyer.city')
                    ->select('Buyer.name as shop_name','Buyer.phone_num',
                    'Buyer.open_time','Buyer.close_time','Buyer.province','p.name as province_name','A.name as area_name','C.name as city_name','Buyer.city','Buyer.area','Buyer.address_detail','F.url','Buyer.lat','Buyer.buyer_category','Buyer.lng')
                    ->first();
        $data=ShopDetailImage:: where('buyer',$buyer)
                    ->leftJoin('ShopImageFile as F','F.seq', '=', 'ShopDetailImage.shop_image_file')
                    ->select('ShopDetailImage.order_num','ShopDetailImage.seq',
                    'F.url')
                    ->orderBy('ShopDetailImage.order_num','asc')
                    ->get();
        if($items['open_time']){
            $time = explode(':',$items['open_time']);
            $items['open_time'] = $time[0].':'.$time[1];
        }
        if($items['close_time']){
            $time = explode(':',$items['close_time']);
            $items['close_time'] = $time[0].':'.$time[1];
        }
        $items['detailImage']=$data;
        if(empty($items)){
            return $this->responseNotFound('没有数据','');
        }
        return $this->responseOK('Ok',$items);
    }

    public function category(Request $request){
        $lang = $request->session()->get('locale');
        $data = ShopCategory::select('seq', 'name_'.$lang.' as name')->orderBy('seq', 'asc')->get();
        return $this->responseOK('Ok',$data);
    }

    public function modify(Request $request){
        $seq = $this->buyer_id;
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
            'cropped_detail_image_5',
            'detail_image_array'
        ]);
// dd($input);
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
            'cropped_detail_image_5' => 'nullable',
            'detail_image_array'     => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->responseBadRequest('参数错误', 401);//error code 400,401
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
        }else if(!$Buyer->shop_logo_image_file){
            return $this->responseBadRequest('Upload logo first', 403);//error code 400,403
        }
        for ($i=0; $i < count($input['detail_image_array']); $i++) { 
            if($input['detail_image_array'][$i]==0){
                ShopDetailImage::where('buyer', $seq)
                    ->where('order_num',$i+1)
                    ->delete();
            }
        }
        for ($i=1; $i < 6; $i++) { 
            $a = 'detailImage'.$i;
            $$a = $request->file('cropped_detail_image_'.$i);
            if($$a){
                $oldShopDetailImage = ShopDetailImage::where('buyer', $Buyer->seq)
                    ->where('order_num', $i)
                    ->delete();
                $shopDetailImage = FileHelper::shopDetailImage($$a);
                $shopDetailImage = ShopImageFile::create($shopDetailImage);
                ShopDetailImage::create([
                    'type'             => 'event',
                    'order_num'        => $i,
                    'buyer'            => $Buyer->seq,
                    'shop_image_file'  => $shopDetailImage->seq
                ]);
            }
        }
        $Buyer->name = $input['name'];
        $Buyer->buyer_category = $input['buyer_category'];
        $Buyer->phone_num = $input['phone_num'];
        $Buyer->open_time = $input['open_time'];
        $Buyer->close_time = $input['close_time'];
        $Buyer->country = $input['country'];
        $Buyer->province = $input['province'];
        $Buyer->city = $input['city'];
        $Buyer->area = $input['area'];
        $Buyer->address_detail = $input['address_detail'];
        $Buyer->lat = $input['lat'];
        $Buyer->lng = $input['lng'];
        $Buyer->save();
        return $this->responseOK('success','');
    }

    public function deleteImage(Request $request)
    {
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
            return $this->responseBadRequest('参数错误', 401);//error code 400,401
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
        $this->formatImage();
        return $this->responseOK('success','');
    }

    protected function formatImage()
    {
        $buyer = $this->buyer_id;
        $images = ShopDetailImage::where('buyer', $buyer)->orderBy('order_num','asc')->get();
        $i = 1;
        foreach ($images as $image) {
            $image->order_num = $i;
            $image->save();
            $i++;
        }
    }

    public function createCoupon(Request $request){
        $buyer = $this->buyer_id;
        $input=Input::only('coupon_name','quantity','coupon_type','discount_money','discount_percent',
                          'max_discount_money','limit_type','limit_money','image','limit_count','coupon_date_type','start_at','expired_at','days',
                          'available_time_type', 'available_time','business_hours','is_special_goods','pkgList','condition','goods_name','remark','is_festival','is_weekend'
                          ,'time_limit'
                        );
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
            'time_limit'              => 'nullable|array',
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
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyDiscountMoney'));
            }
        }
        if($couponType == 1){
             //折扣率
            if(empty($discountPercent)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyDiscountPercent'));
            }
            //最大优惠
            if(empty($maxDiscountMoney)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyMaxDiscountMoney'));
           }
           if($discountPercent<1 || $discountPercent>9.9){
            return $this->responseNotFound(trans('shop\createCoupon.verification.discountPercentError'));
           }
        }
        //验证使用门槛类型
        if($limitType == 0){
            $limitMoney=0;
        }
        if($limitType == 1){
            if(empty($limitMoney)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyLimitMoney'));
            }
            if($limitMoney <= 0){
                return $this->responseNotFound(trans('shop\createCoupon.verification.limitMoneyError'));
            }
        }
        //验证优惠券有效期
        if( $couponDateType == 0){
           if(empty($startAt)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyStartAt'));
            }
            if(empty($expiredAt)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyExpiredAt'));
            }
            if($startAt >= $expiredAt){
                return $this->responseNotFound(trans('shop\createCoupon.verification.timeError'));
            }
        }
        if($couponDateType == 1){
            if(empty($days)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyDays'));
            }  
            if($days<1 || $days>365){
                return $this->responseNotFound(trans('shop\createCoupon.verification.daysError'));
            }   
        }
        //验证有效时间段
        if ($availableTimeType == 0){
            $availableTime=0;
         }
        if ($availableTimeType == 1){
            if(empty($availableTime)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyAvailableTime'));
            }else{
                $availableTime = implode('',$availableTime);
            }
            $limit = 1;
            if(isset($input['time_limit'])){
                foreach ($input['time_limit'] as $key => $value) {
                    if($value['start_at']&&$value['end_at']&&$limit<4){
                        $data['time_limit'.$limit.'_start_at'] = $value['start_at'];
                        $data['time_limit'.$limit.'_end_at'] = $value['end_at'];
                        $limit = $limit + 1;
                    }
                }
            }
         }
        //验证优惠使用条件
        if ( $isSpecialGoods == 1){
            if(empty($goodsName)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyGoodsName'));
            }
        }
        $data['coupon_name'] = $couponName;
        $data['quantity'] = $quantity;
        $data['coupon_type'] = $couponType;
        $data['discount_money'] = $discountMoney;
        $data['discount_percent'] = $discountPercent;
        $data['max_discount_money'] = $maxDiscountMoney;
        $data['image'] = $image;
        $data['limit_money'] = $limitMoney;
        $data['limit_count'] = $limitCount;
        $data['start_at'] = $startAt;
        $data['expired_at'] = $expiredAt;
        $data['days'] = $days;
        $data['available_time'] = $availableTime;
        $data['business_hours'] = $businessHours;
        $data['condition'] = $condition;
        $data['is_special_goods'] = $isSpecialGoods;
        $data['goods_name'] = $goodsName;
        $data['remark'] = $remark;
        $data['status'] = 'registered';
        $data['buyer_id'] = $buyer;
        $data['is_weekend'] = $is_weekend;
        $data['is_festival'] = $is_festival;
        $data = ShopCoupon::create($data);
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
            return $this->responseNotFound('没有数据');
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
        $buyer_id = $this->buyer_id;
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
            return $this->responseBadRequest('参数错误',401);
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
            return $this->responseBadRequest('参数错误');
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
            return $this->responseNotFound('参数错误');
        }else{
            $item['limit_type'] = $item['limit_money']?1:0;
            $item['start_at'] =  Carbon::parse($item['start_at'])->toDateString();
            $item['expired_at'] =  Carbon::parse($item['expired_at'])->toDateString();
            $item['available_time_type'] = $item['available_time']?1:0;
            if($item['available_time']){
                $item['available_time'] = str_split($item['available_time']);
            }
            $time_limit = [];
            for ($i=1; $i < 4; $i++) { 
                if($item['time_limit'.$i.'_end_at']){
                    unset($limit);
                    $time = explode(':',$item['time_limit'.$i.'_start_at']);
                    $limit['start_at'] = $time[0].':'.$time[1];
                    $time = explode(':',$item['time_limit'.$i.'_end_at']);
                    $limit['end_at'] = $time[0].':'.$time[1];
                    $time_limit[] = $limit;
                }else{
                    break;
                }
            }
            unset($item['time_limit1_end_at'],$item['time_limit2_end_at'],$item['time_limit3_end_at'],$item['time_limit1_start_at'],$item['time_limit2_start_at'],$item['time_limit3_start_at']);
            $item['time_limit'] = $time_limit;
            $item['coupon_date_type'] = $item['days']?1:0;
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
        $buyer = $this->buyer_id;
        $input=Input::only('id','is_code_changed','coupon_name','quantity','coupon_type','discount_money','discount_percent',
                          'max_discount_money','limit_type','limit_money','image','limit_count','coupon_date_type','start_at','expired_at','days',
                          'available_time_type', 'available_time','business_hours','is_special_goods','pkgList','condition','goods_name','remark','is_festival','is_weekend','time_limit');
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
            'id'                      => 'required|integer',
            'is_code_changed'         => 'required|in:0,1',
            'time_limit'              => 'nullable|array',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }   
        $id = $request->input('id');
        $item = ShopCoupon::where('shop_coupon.id',$id)->where('buyer_id',$buyer)->first();
        if(empty($item)){
            return $this->responseNotFound('参数错误');
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
        $id = $request->input('id');
        $is_code_changed = $request->input('is_code_changed');
        //验证优惠类型
        if($couponType == 0){
             //面值
            if(empty($discountMoney)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyDiscountMoney'));
            }
        }
        if($couponType == 1){
             //折扣率
            if(empty($discountPercent)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyDiscountPercent'));
            }
            //最大优惠
            if(empty($maxDiscountMoney)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyMaxDiscountMoney'));
           }
           if($discountPercent<1 || $discountPercent>9.9){
            return $this->responseNotFound(trans('shop\createCoupon.verification.discountPercentError'));
           }
        }
        //验证使用门槛类型
        if($limitType == 0){
            $limitMoney=0;
        }
        if($limitType == 1){
            if(empty($limitMoney)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyLimitMoney'));
            }
            if($limitMoney <= 0){
                return $this->responseNotFound(trans('shop\createCoupon.verification.limitMoneyError'));
            }
        }
        //验证优惠券有效期
        if( $couponDateType == 0){
           if(empty($startAt)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyStartAt'));
            }
            if(empty($expiredAt)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyExpiredAt'));
            }
            if($startAt >= $expiredAt){
                return $this->responseNotFound(trans('shop\createCoupon.verification.timeError'));
            }
        }
        if($couponDateType == 1){
            if(empty($days)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyDays'));
            }  
            if($days<1 || $days>365){
                return $this->responseNotFound(trans('shop\createCoupon.verification.daysError'));
            }   
        }
        //验证有效时间段
        if ($availableTimeType == 0){
            $availableTime=0;
         }
        if ($availableTimeType == 1){
            if(empty($availableTime)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyAvailableTime'));
            }else{
                $availableTime = implode('',$availableTime);
            }
            $item->time_limit1_start_at = NULL;
            $item->time_limit1_end_at = NULL;
            $item->time_limit2_start_at = NULL;
            $item->time_limit2_end_at = NULL;
            $item->time_limit3_start_at = NULL;
            $item->time_limit3_end_at = NULL;
            $limit = 1;
            if(isset($input['time_limit'])){
                foreach ($input['time_limit'] as $key => $value) {
                    if($value['start_at']&&$value['end_at']&&$limit<4){
                        if($limit==1){
                            $item->time_limit1_start_at = $value['start_at'];
                            $item->time_limit1_end_at = $value['end_at'];
                        }elseif ($limit==2) {
                            $item->time_limit2_start_at = $value['start_at'];
                            $item->time_limit2_end_at = $value['end_at'];
                        }elseif ($limit==3) {
                            $item->time_limit3_start_at = $value['start_at'];
                            $item->time_limit3_end_at = $value['end_at'];
                        }
                        $limit = $limit + 1;
                    }
                }
            }
         }
        //验证优惠使用条件
        if ( $isSpecialGoods == 1){
            if(empty($goodsName)){
                return $this->responseNotFound(trans('shop\createCoupon.verification.emptyGoodsName'));
            }
        }
       
        $item->coupon_name = $couponName;
        $item->quantity = $quantity;
        $item->coupon_type = $couponType;
        $item->discount_money = $discountMoney;
        $item->discount_percent = $discountPercent;
        $item->max_discount_money = $maxDiscountMoney;
        $item->image = $image;
        $item->limit_money = $limitMoney;
        $item->limit_count = $limitCount;
        $item->start_at = $startAt;
        $item->expired_at = $expiredAt;
        $item->days = $days;
        $item->available_time = $availableTime;
        $item->business_hours = $businessHours;
        $item->condition = $condition;
        $item->is_special_goods = $isSpecialGoods;
        $item->goods_name = $goodsName;
        $item->remark = $remark;
        $item->status='registered';
        $item->buyer_id = $buyer;
        $item->is_weekend = $is_weekend;
        $item->is_festival = $is_festival;
        $item->save();
        $pkgSeqList = $request->input('pkgList');
        $isChanged = $request->input('is_code_changed');
        if($isChanged){
            Shop2Q35Package::where('shop_coupon',$item->id)->forceDelete();
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
                            'shop_coupon'      => $item->id,
                            'q35package'       => $v1['seq']
                        ]);
                    }
                }
            }
        }
        return $this->responseOk('',$item);  
    }
}
