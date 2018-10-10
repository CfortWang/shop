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

  public function groupon() {
    return view('web.contents.event.groupon',[
        'title' => '拼豆豆',
      ]);
  }

  public function createGroup() {
    return view('web.contents.event.createGroup',[
        'title' => '新建拼豆豆',
      ]);
  }

  public function coupon() {
    return view('web.contents.event.coupon',[
        'title' => '优惠券',
      ]);
  }

  public function createCoupon() {
    return view('web.contents.event.createCoupon',[
        'title' => '新建优惠券',
      ]);
  }

  public function message() {
    return view('web.contents.event.message',[
      'title' => '消息通知',
    ]);
  }

  public function createMessage() {
    return view('web.contents.event.createMessage',[
        'title' => '新建消息',
      ]);
  }

  public function grouponDetails() {
    return view('web.contents.event.grouponDetails',[
        'title' => '拼豆豆详情',
      ]);
  }

  public function couponDetails() {
    return view('web.contents.event.couponDetails',[
        'title' => '优惠券详情',
      ]);
  }

  public function messageDetails() {
    return view('web.contents.event.messageDetails',[
        'title' => '消息详情',
      ]);
  }
}
