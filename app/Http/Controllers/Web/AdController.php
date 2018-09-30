<?php

namespace App\Http\Controllers\Web;
use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AdController extends Controller
{
  public function __construct()
  {
  }
  public function list() {
    return view('web.contents.ad.list',[
        'title' => '广告列表',
      ]);
  }
  public function createAd() {
    return view('web.contents.ad.register',[
        'title' => '新增广告',
      ]);
  }

}
