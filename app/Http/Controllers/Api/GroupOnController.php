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
use App\Models\GrouponItem;

class GroupOnController extends Controller
{
    public function __construct(Request $request)
    {
        $this->buyer_id =  $request->session()->get('buyer.seq');
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
        $input=Input::only('title','price','discounted_price','group_size','remark','rule','open_time','close_time','start_use_time','end_use_time','is_weekend','is_festival','logo','image','product','continued_time','is_effective_fixed','is_usetime_limit','effective_start_at','effective_end_at','time_limit','days','effective_days');
        $message =  $messages = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        ];
        $validator = Validator::make($input, [
            'title'                => 'required|string',
            'price'                => 'required|numeric',
            'discounted_price'     => 'required|numeric',
            'group_size'           => 'required|numeric|max:20|min:2',
            'remark'               => 'nullable|array',
            'rule'                 => 'required|string',
            'open_time'            => 'required|date',
            'close_time'           => 'required|date',
            'continued_time'       => 'required|numeric',
            'is_weekend'           => 'nullable|boolean',
            'is_festival'          => 'nullable|boolean',
            'logo'                 => 'required|string',
            'image'                => 'required|array',
            'product'              => 'required|array',
            'is_effective_fixed'   => 'required|in:0,1',
            'is_usetime_limit'     => 'required|in:0,1',
            'effective_start_at'   => 'nullable|string',
            'effective_end_at'     => 'nullable|string',
            'time_limit'           => 'nullable|array' ,
            'days'                 => 'nullable|array',
            'effective_days'       => 'nullable|numeric',
        ],$message);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }
        $res  = 1;
        $data['title'] = $input['title'];
        $data['price'] = $input['price'];
        $data['discounted_price'] = $input['discounted_price'];
        $data['group_size'] = $input['group_size'];
        $data['remark'] = isset($input['remark'])?implode('孻孼孽孾',$input['remark']):'';
        $data['rule'] = $input['rule'];
        $data['buyer_id'] = $buyer_id;
        $data['product_status'] = 0;
        $data['open_time'] = $input['open_time'];
        $data['close_time'] = $input['close_time'];
        $data['effective_day'] = Carbon::now()->addWeeks(3);
        $data['continued_time'] = $input['continued_time']*60;
        $data['groupon_price'] = 0.01;
        $data['image'] = $input['logo'];
        $data['is_effective_fixed'] = $input['is_effective_fixed'];
        $data['is_usetime_limit'] = $input['is_usetime_limit'];
        if($data['is_effective_fixed']==1){
            $data['effective_start_at'] = $input['effective_start_at'];
            $data['effective_end_at'] = $input['effective_end_at'];
        }else{
            $data['effective_days'] = $input['effective_days'];
        }
        if($data['is_usetime_limit']==1){
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
            $day = 0;
            $day = isset($input['days'])?implode('',$input['days']):0;
            $data['days_limit'] = $day;
            $data['is_weekend'] = isset($input['is_weekend'])?$input['is_weekend']:0;
            $data['is_festival'] = isset($input['is_festival'])?$input['is_festival']:0;
        }
        $res = GrouponProduct::create($data);
        foreach ($input['image'] as $key => $value) {
            if($value){
                $image['groupon_product_id'] = $res->id;
                $image['image_url'] = $value;
                GrouponImage::create($image);
            }
        }
        foreach ($input['product'] as $key => $value) {
            if($value['name']){
                $item['title'] = $value['name'];
                $item['price'] = $value['price']?$value['price']:0;
                $item['quantity'] = $value['quantity']?$value['quantity']:1;
                $item['groupon_product_id'] = $res->id;
                GrouponItem::create($item);
            }
        }
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
        
        // $path = 
    }

    public function modify()
    {
        $buyer_id = $this->buyer_id;
        $input=Input::only('id','title','price','discounted_price','group_size','remark','rule','open_time','close_time','start_use_time','end_use_time','is_weekend','is_festival','logo','image','product','continued_time','is_effective_fixed','is_usetime_limit','effective_start_at','effective_end_at','time_limit','days','effective_days','is_image_modify','is_product_modify');
        $message =  $messages = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        ];
        $validator = Validator::make($input, [
            'id'                   => 'required|numeric',
            'title'                => 'required|string',
            'price'                => 'required|numeric',
            'discounted_price'     => 'required|numeric',
            'group_size'           => 'required|numeric|max:20|min:2',
            'remark'               => 'nullable|array',
            'rule'                 => 'required|string',
            'open_time'            => 'required|date',
            'close_time'           => 'required|date',
            'continued_time'       => 'required|numeric',
            'is_weekend'           => 'nullable|boolean',
            'is_festival'          => 'nullable|boolean',
            'logo'                 => 'required|string',
            'image'                => 'required|array',
            'product'              => 'required|array',
            'is_effective_fixed'   => 'required|in:0,1',
            'is_usetime_limit'     => 'required|in:0,1',
            'effective_start_at'   => 'nullable|string',
            'effective_end_at'     => 'nullable|string',
            'time_limit'           => 'nullable|array' ,
            'days'                 => 'nullable|array',
            'effective_days'       => 'nullable|numeric',
            'is_image_modify'      => 'required|boolean',
            'is_product_modify'    => 'required|boolean',
        ],$message);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }
        $product = GrouponProduct::where('id',$input['id'])->where('buyer_id',$buyer_id)->first();
        if(!$product){
            return $this->responseBadRequest('');
        }
        $product->title = $input['title'];
        $product->price = $input['price'];
        $product->discounted_price = $input['discounted_price'];
        $product->group_size = $input['group_size'];
        $product->remark = isset($input['remark'])?implode('孻孼孽孾',$input['remark']):'';
        $product->rule = $input['rule'];
        $product->buyer_id = $buyer_id;
        $product->product_status = 0;
        $product->open_time = $input['open_time'];
        $product->close_time = $input['close_time'];
        $product->effective_day = Carbon::now()->addWeeks(3);
        $product->continued_time = $input['continued_time']*60;
        $product->groupon_price = 0.01;
        $product->image = $input['logo'];
        $product->is_effective_fixed = $input['is_effective_fixed'];
        $product->is_usetime_limit = $input['is_usetime_limit'];
        if($product->is_effective_fixed==1){
            $product->effective_start_at = $input['effective_start_at'];
            $product->effective_end_at = $input['effective_end_at'];
        }else{
            $product->effective_days = $input['effective_days'];
        }
        if($product->is_usetime_limit==1){
            $limit = 1;
            $product->time_limit1_start_at = NULL;
            $product->time_limit1_end_at = NULL;
            $product->time_limit2_start_at = NULL;
            $product->time_limit2_end_at = NULL;
            $product->time_limit3_start_at = NULL;
            $product->time_limit3_end_at = NULL;
            if(isset($input['time_limit'])){
                foreach ($input['time_limit'] as $key => $value) {
                    if($value['start_at']&&$value['end_at']&&$limit<4){
                        if($limit==1){
                            $product->time_limit1_start_at = $value['start_at'];
                            $product->time_limit1_end_at = $value['end_at'];
                        }elseif ($limit==2) {
                            $product->time_limit2_start_at = $value['start_at'];
                            $product->time_limit2_end_at = $value['end_at'];
                        }elseif ($limit==3) {
                            $product->time_limit3_start_at = $value['start_at'];
                            $product->time_limit3_end_at = $value['end_at'];
                        }
                        $limit = $limit + 1;
                    }
                }
            }
            $day = 0;
            $day = isset($input['days'])?implode('',$input['days']):0;
            $product->days_limit = $day;
            $product->is_weekend = isset($input['is_weekend'])?$input['is_weekend']:0;
            $product->is_festival = isset($input['is_festival'])?$input['is_festival']:0;
        }
        $res = $product->save();
        if($input['is_image_modify']){
            GrouponImage::where('groupon_product_id',$product->id)->delete();
            foreach ($input['image'] as $key => $value) {
                if($value){
                    $image['groupon_product_id'] = $product->id;
                    $image['image_url'] = $value;
                    GrouponImage::create($image);
                }
            }
        }
        if($input['is_product_modify']){
            GrouponItem::where('groupon_product_id',$product->id)->delete();
            foreach ($input['product'] as $key => $value) {
                if($value['name']){
                    $item['title'] = $value['name'];
                    $item['price'] = $value['price']?$value['price']:0;
                    $item['quantity'] = $value['quantity']?$value['quantity']:1;
                    $item['groupon_product_id'] = $product->id;
                    GrouponItem::create($item);
                }
            }
        }
        return $this->responseOk('',$res);
    }

    public function detail(Request $request,$id)
    {
        $buyer_id = $this->buyer_id;
        $data = GrouponProduct::where('id',$id)->where('buyer_id',$buyer_id)->select("title","price","discounted_price","group_size","remark","rule","continued_time","is_weekend","is_festival","product_status","effective_day","open_time","close_time","start_use_time","end_use_time","image as logo","groupon_price","is_effective_fixed","effective_start_at","effective_end_at","is_usetime_limit","time_limit1_start_at","time_limit2_start_at","time_limit3_start_at","time_limit1_end_at","time_limit2_end_at","time_limit3_end_at","days_limit","effective_days")->first();
        if($data){
            $data['product'] = GrouponItem::where('groupon_product_id',$id)->select('title','price','quantity')->get();
            $image = GrouponImage::where('groupon_product_id',$id)->select('image_url')->get();
            if($image){
                foreach ($image as $key => $value) {
                    $image[$key]['image_url'] = $value['image_url'];
                }
                $data['image'] = $image;
            }else{
                $data['image'] = [];
            }
            if($data['is_usetime_limit']){
                $data['days'] = str_split($data['days_limit']);
            }
            if($data['remark']){
                $remark = explode('孻孼孽孾',$data['remark']);
            }else{
                $remark = [];
            }
            $data['remark'] = $remark;
            
            $time_limit = [];
            for ($i=1; $i < 4; $i++) { 
                if($data['time_limit'.$i.'_end_at']){
                    unset($limit);
                    $limit['start_at'] = $data['time_limit'.$i.'_start_at'];
                    $limit['end_at'] = $data['time_limit'.$i.'_end_at'];
                    $time_limit[] = $limit;
                }else{
                    break;
                }
            }
            unset($data['time_limit1_end_at'],$data['time_limit2_end_at'],$data['time_limit3_end_at'],$data['time_limit1_start_at'],$data['time_limit2_start_at'],$data['time_limit3_start_at']);
            $data['time_limit'] = $time_limit;
            $data['continued_time'] = $data['continued_time']/60;
        }else{
            return $this->responseBadRequest('');
        }
        return $this->responseOk('',$data);
    }
}