<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;
use Hash;
use App\Models\Buyer;

class LoginController extends Controller
{
  public function __construct()
  {
  }

  public function login(Request $request)
  {

    // return view('web.contents.login.index',[
    //     'title' => 'login page',
    //   ]);
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
    return $this->responseOk('access success');
  }

}
