<?php

namespace App\Http\Controllers\Web;
use App;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class StatisticsController extends Controller
{
    public function __construct()
    {
    }

    public function new()
    {
        return view('web.contents.statistics.new',[
            'title' => '',
        ]);
    }

    public function analysis()
    {
        return view('web.contents.statistics.analysis',[
            'title' => '',
        ]);
    }

    public function active()
    {
        return view('web.contents.statistics.active',[
            'title' => '',
        ]);
    }

    public function silence()
    {
        return view('web.contents.statistics.silence',[
            'title' => '',
        ]);
    }

    public function frequency()
    {
        return view('web.contents.statistics.frequency',[
            'title' => '',
        ]);
    }

}
