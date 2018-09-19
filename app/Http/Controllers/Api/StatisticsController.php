<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendCodeHelper;
use Validator;
use Hash;
use Carbon\Carbon;
use App\Models\UserScanLog;
use App\Models\PhoneNumCertification;

class StatisticsController extends Controller
{
    public function __construct()
    {
    }

    public function newCustomer()
    {
        $seq  = 1;
        $days = Input::get('days', 30);
        $range = Carbon::now()->subDays($days);
        // 按天
        // $data = UserScanLog::where('created_at', '>=', $range)
        //     ->where('buyer',$seq)
        //     ->groupBy('date','user')
        //     ->orderBy('date', 'DESC')
        //     ->get([
        //         DB::raw('Date(created_at) as date'),
        //         DB::raw('COUNT(*) as value'),
        //     ]);

        // 按月
        $data = UserScanLog::where('created_at', '>=', $range)
            ->where('buyer',$seq)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get([
                DB::raw('DATE_FORMAT(created_at,"%Y-%u") as date'),
                DB::raw('COUNT(*) as value'),
            ]);
            $return['data'] = [];
            $return['item'] = [];
        foreach ($data as $key => $value) {
            $return['item'][] = $value['date'];
            $return['data'][] = $value['value'];
        }
        return $this->responseOk('access success',$return);
    }
}