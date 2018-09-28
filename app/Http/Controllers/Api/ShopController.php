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
use App\Models\ShopCategory;
use App\Models\ShopDetailImage;
use App\Models\ShopImageFile;

class ShopController extends Controller
{
    public function __construct()
    {
    }

    public function info(Request $request){
        $seq = $request->session()->get('buyer.seq');
        $buyer=14;
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
            // if ($imageWidth !== 180 || $imageHeight !== 180) {
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
        $buyer=14;
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
        if ($imageType === 'shop_logo') {
            $Buyer->shop_logo_image_file = null;
            $Buyer->save();
        } else if ($imageType === 'shop_detail') {
            ShopDetailImage::where('buyer', $buyer)
            ->where('seq',$input['detailSeq'] )
            ->delete();
        } 

        return $this->responseOK('success','');
    }
}
