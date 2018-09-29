<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;
use Carbon\Carbon;

use App\Models\GrouponProduct;
use App\Models\Groupon;
use App\Models\GrouponRecord;
use App\Models\GrouponImage;
class GroupOnController extends Controller
{
    public function __construct()
    {
        $this->buyer_id = 1;
    }

    public function list(Request $request)
    {
        $buyer_id = $this->buyer_id;
        
        $title = $request->input('keyword');
        if($title){
            $product = GrouponProduct::where('buyer_id',$buyer_id)
                ->where('title','LIKE','%'.$title.'%')
                ->select('id','title','price','discounted_price','join_number','product_status','effective_day')
                ->get();
        }else{
            $product = GrouponProduct::where('buyer_id',$buyer_id)
                ->select('id','title','price','discounted_price','join_number','product_status','effective_day')
                ->get();
        }
        foreach ($product as $key => $value) {
            $product[$key]['unused'] = 0;
            $product[$key]['used'] = 0;
            $data = Groupon::where('groupon.groupon_product_id',$value['id'])
                ->leftJoin('groupon_record as a','a.groupon_id','=','groupon.id')
                ->select('a.paid_status','a.groupon_id')
                ->get();
                unset($group);
                $group = [];
                foreach ($data as $k => $val) {
                    if($val['paid_status']==1){
                        $product[$key]['unused'] = $product[$key]['unused']+1;
                    }elseif ($val['paid_status']==2) {
                        $product[$key]['used'] = $product[$key]['used']+1;
                    }
                    $group[$val['groupon_id']] = 1;
                }
            $product[$key]['group'] = count($group);
        }
        return $this->responseOk('',$product);
    }

    public function create(Request $request)
    {
        $buyer_id = $this->buyer_id;
        $input=Input::only('title','price','discounted_price','group_size','remark','rule','open_time','close_time','start_use_time','end_use_time','is_weekend','is_festival','logo','image','product','continued_time');
        $message =  $messages = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        ];
        $validator = Validator::make($input, [
            // 'title'                => 'required|string',
            // 'price'                => 'required|numeric',
            // 'discounted_price'     => 'required|numeric',
            // 'group_size'           => 'required|numeric|max:20|min:2',
            // 'remark'               => 'required|string',
            // 'rule'                 => 'required|string',
            // 'open_time'            => 'required|date',
            // 'close_time'           => 'required|date',
            // 'start_use_time'       => 'required',
            // 'end_use_time'         => 'required',
            // 'continued_time'          => 'required|numeric',
            // 'is_weekend'           => 'required|boolean',
            // 'is_festival'          => 'required|boolean',
            // 'logo'                 => 'required|image',
            'image'                => 'required|array',
            // 'product'              => 'required|array',
        ],$message);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }
        // $image = FileHelper::groupOnImage($input['image']);
        for ($i=0; $i < count($input['image']); $i++) { 
            if(isset($input['image'][$i])){
                $image = FileHelper::groupOnImage($input['image'][$i]);
                $product['groupon_product_id'] = 9;
                $product['image_url'] = $image['url'];
                GrouponImage::create($product);
            }
        }
        $res  = 1;
        // dd(1);
        // dd($image['url']);
        // dd($input['image']);
        // dd($input['product']);
        // $data['title'] = $input['title'];
        // $data['price'] = $input['price'];
        // $data['discounted_price'] = $input['discounted_price'];
        // $data['group_size'] = $input['group_size'];
        // $data['remark'] = $input['remark'];
        // $data['rule'] = $input['rule'];
        // $data['buyer_id'] = $buyer_id;
        // $data['product_status'] = 1;
        // $data['open_time'] = $input['open_time'];
        // $data['close_time'] = $input['close_time'];
        // $data['start_use_time'] = $input['start_use_time'];
        // $data['end_use_time'] = $input['end_use_time'];
        // $data['is_weekend'] = $input['is_weekend'];
        // $data['is_festival'] = $input['is_festival'];
        // $data['effective_day'] = Carbon::now()->addWeeks(3);
        // $data['continued_time'] = $input['continued_time'];
        // $data['groupon_price'] = 0.001;
        // $data['image'] = 'https://s1.ax1x.com/2018/09/26/iMNRat.png';
        // $res = GrouponProduct::create($data);
        return $this->responseOk('',$res);
    }

    public function status(Request $request)
    {
        $buyer_id = $this->buyer_id;
        $input=Input::only('id','status');
        $message = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        ];
        $validator = Validator::make($input, [
            'id'                => 'required|numeric',
            'status'                => 'required|in:0,1',
        ],$message);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }
        $id = $input['id'];
        $status = $input['status'];
        $product = GrouponProduct::where('id',$id)->where('buyer_id',$buyer_id)->where('product_status',$status)->first();
        if($product){
            $product->product_status = intval(!$status);
            $product->save();
            return $this->responseOk('',intval(!$status));
        }else{
            return $this->responseBadRequest('操作失败');
        }
    }

    public function upload(Request $request)
    {
        $input=Input::only('file');
        $validator = Validator::make($input, [
            'file'                 => 'required|image',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('格式错误');
        }
        $image = FileHelper::groupOnImage($input['file']);
        return $this->responseOk('',$image);
    }

    public function moveFile()
    {
        $url = 'beta-media.beanpop.cn/temp/shop/groupon/2b6a1cdb30e0bc8060728166aeb227fd.png';
        
        $path = 
    }
}