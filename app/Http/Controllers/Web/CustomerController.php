<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class CustomerController extends Controller
{
  public function __construct()
  {
  }

  public function scannedList()
  {
    return view('web.contents.customer.scanned',[
        // 'title' => 'login page',
      ]);
  }

}
