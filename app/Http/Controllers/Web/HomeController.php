<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class HomeController extends Controller
{
  public function __construct()
  {
  }

  public function index()
  {
    return view('web.contents.home.index',[
        'title' => 'Home page',
      ]);
  }

}
