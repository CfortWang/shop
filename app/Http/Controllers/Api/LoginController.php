<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendCodeHelper;
use Validator;
use Hash;
use Session;
use App\Models\Buyer;
use App\Models\PhoneNumCertification;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $input = Input::only('phone', 'password');

        $validator = Validator::make($input, [
            'phone'           => 'required',
            'password'           => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('Bad Request');
        }
        $loginID  = $request->input('phone');
        $loginPW = $request->input('password');
        $buyer = Buyer::where('rep_phone_num', $loginID)->first();
        if (empty($buyer)){
            return $this->responseBadRequest('ID can not be find.', 101);
        } 
        if (!Hash::check($loginPW, $buyer->password)){
            return $this->responseBadRequest('Incorrect Password', 102);
        }
        $request->session()->put('buyer.seq', $buyer->seq);
        $request->session()->put('buyer.id', $buyer->rep_phone_num);
        // dd(Session::all());
        return $this->responseOk('access success');
    }

    public function code(Request $request)
    {
        $input = Input::only('phone','password','code','repeatPassword');

        $validator = Validator::make($input, [
            'phone'           => 'required',
            'code'            => 'required',
            'password'        => 'required',
            'repeatPassword'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('Bad Request');
        }
        if($request->input('password')!==$request->input('repeatPassword')){
            return $this->responseBadRequest('password not match');
        }
        $loginID  = $request->input('phone');
        $code = $request->input('code');
        $password = $request->input('password');
        $buyer = Buyer::where('rep_phone_num', '100')->first();
        // if (empty($buyer)){
        //     return $this->responseBadRequest('ID can not be find.', 101);
        // } 
        // if (!Hash::check($loginPW, $buyer->password)){
        //     return $this->responseBadRequest('Incorrect Password', 102);
        // }
        $cert = PhoneNumCertification::where('phone_num', $loginID)
            ->where('type','shop_find_pw')
            ->orderBy('created_at', 'desc')
            ->first();
        if (empty($cert)){
            return $this->responseNotFound('code error');
        } 
        if ($cert->code != $code) {
            return $this->responseBadRequest('code error');
        }
        $buyer->password =  password_hash($password, PASSWORD_BCRYPT);
        $buyer->save();
        $request->session()->put('buyer.seq', $buyer->seq);
        $request->session()->put('buyer.id', $buyer->rep_phone_num);
        return $this->responseOk('access success');
    }

    public function sendCode(Request $request)
    {
        $input = Input::only('phone');

        $validator = Validator::make($input, [
            'phone'           => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('Bad Request');
        }
        $phone = $input['phone'];
        $buyer = Buyer::where('rep_phone_num', $phone)->first();
        // if (empty($buyer)){
        //     return $this->responseBadRequest('ID can not be find.', 101);
        // }
        $country_calling_code = 86;
        $country_seq = 1;
        $code = rand(100000, 999999);
        $result = SendCodeHelper::send($country_calling_code,$phone,$code);
        $type = 'shop_find_pw';
        if ($result->code == 2) {
            PhoneNumCertification::create([
                'country'       => $country_seq,
                'phone_num'     => $phone,
                'code'          => $code,
                'type'          => $type,
                'calling_code'  => $country_calling_code,
            ]);
            return $this->responseOk(trans('login.messageSendSuccess'));
        } else {
            return $this->responseServerError(trans('login.messageSendFailed'), $result);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
    }

    
}
