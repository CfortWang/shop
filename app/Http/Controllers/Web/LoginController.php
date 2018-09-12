<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class LoginController extends Controller
{
  public function __construct()
  {
  }

  public function login()
  {
    return view('web.contents.login.index',[
        'title' => 'login page',
      ]);
  }

}
