<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;
use Carbon\Carbon;

use App\Models\ShopMessage;
use App\Models\ShopMessageUser;

class MessageController extends Controller
{
    public function __construct(Request $request)
    {
        $this->buyer_id = $request->session()->get('buyer.seq');
        // $this->lang = 
        $this->objectType[0]['zh'] = '手机号';
        $this->objectType[1]['zh'] = '沉默用户';
        $this->objectType[2]['zh'] = '拼豆成功未使用用户';
        $this->objectType[3]['zh'] = '领取优惠券未使用用户';
        $this->objectType[4]['zh'] = '拼豆失败用户';
        $this->objectType[5]['zh'] = '未知';
        $this->messageStatus[0]['zh'] = '未审核';
        $this->messageStatus[1]['zh'] = '已审核';
        $this->messageStatus[2]['zh'] = '审核被拒';
        $this->messageStatus[3]['zh'] = '已发送';
    }
    
    public function list(Request $request)
    {
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        
        $buyer_id = $this->buyer_id;
        $count = ShopMessage::where('buyer_id',$buyer_id)->count();
        $data = ShopMessage::where('buyer_id',$buyer_id)
                            ->select('id','content','object_type as objectType','send_at as sendAt','message_status as messageStatus','remark')
                            ->get();
        foreach ($data as $key => &$value) {
            if(!$value['sendAt']){
                $value['sendAt'] = 0;
            }
            $value['object'] =  $this->objectType[$value['objectType']]['zh'];
            $value['status'] =  $this->messageStatus[$value['messageStatus']]['zh'];
        }
        $return['count'] = $count;
        $return['data'] = $data;
        return $this->responseOk('',$return);
    }

    public function create(Request $request)
    {
        $buyer_id = $this->buyer_id;
        $input=Input::only('content','message_type','object_type','send_at','phone_num');
        $message =  $messages = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        ];
        $validator = Validator::make($input, [
            'content'                => 'required|string',
            'message_type'           => 'required|numeric',
            'object_type'            => 'required|numeric',
            'send_at'                => 'required|string',
            'phone_num'              => 'nullable|array',
        ],$message);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }
        $data['content'] = $input['content'];
        $data['message_type'] = $input['message_type'];
        $data['object_type'] = $input['object_type'];
        $data['message_status'] = 0;
        $data['buyer_id'] = $buyer_id;

        if($input['send_at']){
            $data['send_at'] = $input['send_at'];
        }
        $res = ShopMessage::create($data);
        if($data['object_type']==0){
            $phone_num = $input['phone_num'];
            if(count($phone_num)){
                $phone_num = array_unique($phone_num);
                foreach ($phone_num as $key => $value) {
                    $phone_user['phone_num'] = $value;
                    $phone_user['shop_message_id'] = $res->id;
                    ShopMessageUser::create($phone_user);
                }
            }
        }
        return $this->responseOk('',$res);
    }

    public function modify(Request $request)
    {
        $buyer_id = $this->buyer_id;
        $input=Input::only('content','message_type','object_type','send_at','phone_num','id','is_phone_num_modify');
        $message =  $messages = [
            "required" => ":attribute ".trans('common.verification.cannotEmpty'),
        ];
        $validator = Validator::make($input, [
            'content'                => 'required|string',
            'message_type'           => 'required|numeric',
            'object_type'            => 'required|numeric',
            'send_at'                => 'required|string',
            'phone_num'              => 'nullable|array',
            'id'                     => 'required|numeric',
            'is_phone_num_modify'    => 'required|string',
        ],$message);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->responseBadRequest($message);
        }
        $id  = $input['id'];
        $data = ShopMessage::where('id',$id)->where('buyer_id',$buyer_id)->first();
        if(empty($data)){
            return $this->responseBadRequest('没有数据');
        }
        $data->content = $input['content'];
        $data->message_type = $input['message_type'];
        $data->object_type = $input['object_type'];

        if($input['send_at']){
            $data->send_at = $input['send_at'];
        }
        $res = $data->save();
        if($data['object_type']==0&&$input['is_phone_num_modify']){
            ShopMessageUser::where('shop_message_id',$id)->delete();
            $phone_num = $input['phone_num'];
            if(count($phone_num)){
                $phone_num = array_unique($phone_num);
                foreach ($phone_num as $key => $value) {
                    $phone_user['phone_num'] = $value;
                    $phone_user['shop_message_id'] = $id;
                    ShopMessageUser::create($phone_user);
                }
            }
        }
        return $this->responseOk('',$res);
    }

    public function detail(Request $request,$id)
    {
        $buyer_id = $this->buyer_id;
        $data = ShopMessage::where('buyer_id',$buyer_id)->where('id',$id)->select('id','content','object_type as objectType','send_at as sendAt','message_status as messageStatus')->first();
        if($data){
            if(!$data['sendAt']){
                $data['sendAt'] = 0;
            }else{
                $time = strtotime($data['sendAt']);
                $data['sendAt'] = date("Y-m-d h:i", $time);
            }
            if($data['objectType']==0){
                $user = ShopMessageUser::where('shop_message_id',$data['id'])->select('phone_num')->get();
                $data['phone'] = $user;
            }
            return $this->responseOk('',$data);
        }else{
            return $this->responseBadRequest('');
        }
    }

    public function delete(Request $request,$id)
    {
        $buyer_id = $this->buyer_id;
        $data = ShopMessage::where('id',$id)->where('buyer_id',$buyer_id)->first();
        if(empty($data)){
            return $this->responseBadRequest('没有数据');
        }
        $res = ShopMessage::where('id',$id)->where('buyer_id',$buyer_id)->delete();
        return $this->responseOk('',$res);
    }
}
