<?php

namespace App\Http\Controllers\Web;
use App;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class CustomerController extends Controller
{
  public function __construct()
  {
  }

  public function scannedList() {
    App::setLocale('zh');
    return view('web.contents.customer.scanned',[
        'title' => '扫码用户',
      ]);
  }

  public function scanDetails() {
    App::setLocale('zh');
    return view('web.contents.customer.scanDetails',[
        'title' => '扫码详情',
      ]);
  }

  public function groupOn() {
    App::setLocale('zh');
    return view('web.contents.customer.groupOn',[
        'title' => '拼豆豆用户',
      ]);
  }

  public function groupDetails() {
    App::setLocale('zh');
    return view('web.contents.customer.groupDetails',[
        'title' => '拼豆豆详情',
      ]);
  }

  public function coupon() {
    App::setLocale('zh');
    return view('web.contents.customer.coupon',[
        'title' => 'details',
      ]);
  }

  public function couponDetails() {
    App::setLocale('zh');
    return view('web.contents.customer.couponDetails',[
        'title' => 'details',
      ]);
  }

}
