<?php

namespace App\Http\Controllers\Web;
use App;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class EventController extends Controller
{
  public function __construct()
  {
  }

  public function info() {
    return view('web.contents.shop.info',[
        'title' => '商家信息',
      ]);
  }

  public function code() {
    return view('web.contents.shop.code',[
        'title' => '喜豆码',
      ]);
  }

  public function purchaseHistory() {
    return view('web.contents.shop.codePurchaseHistory',[
        'title' => '喜豆码购买记录',
      ]);
  }

  public function codeDetails() {
    return view('web.contents.shop.codeDeteils',[
        'title' => '喜豆码详情',
      ]);
  }

}
