<?php

namespace App\Http\Controllers\Web;
use App;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class AccountController extends Controller
{
  public function __construct()
  {
  }
  public function detail() {
    return view('web.contents.account.detail',[
        'title' => '账号信息-账户详情',
      ]);
  }
  public function cashout() {
    return view('web.contents.account.cashout',[
        'title' => '提现',
      ]);
  }
  public function point() {
    return view('web.contents.account.point',[
        'title' => '积分',
      ]);
  }

}
