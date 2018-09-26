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

  public function groupon()
  {
    return view('web.contents.event.groupon',[
        'title' => 'Home page',
      ]);
  }

}
