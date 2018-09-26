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
        // 'title' => 'login page',
      ]);
  }

  public function scanDetails() {
    App::setLocale('zh');
    return view('web.contents.customer.scanDetails',[
        'title' => 'details',
      ]);
  }

}
