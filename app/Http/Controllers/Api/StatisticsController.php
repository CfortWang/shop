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

    public function newCustomer(Request $request)
    {
        $seq  = 1;
        $input = Input::only('startDate', 'endDate', 'dateSpan');

        $validator = Validator::make($input, [
            'startDate'           => 'required',
            'endDate'             => 'required',
            'dateSpan'            => 'required|in:day,week,hour'
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('Bad Request');
        }
        $startDate = Carbon::createFromFormat('Y-m-d',$request->input('startDate'));
        $endDate = Carbon::createFromFormat('Y-m-d',$request->input('endDate'));
        // 按天
        $type = $request->input('dateSpan');
        switch ($type) {
            case 'hour':
                $sql = DB::raw('DATE_FORMAT(created_at,"%H") as date');
                break;
            case 'day':
                $sql = DB::raw('Date(created_at) as date');
                break;
            case 'week':
                $sql = DB::raw('DATE_FORMAT(created_at,"%Y-%U") as date');
                break;
            default:
                # code...
                break;
        }
        $data = UserScanLog::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->where('buyer',$seq)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                $sql,
                DB::raw('COUNT(user) as value'),
            ]);

        $data = $this->formatData($startDate,$endDate,$type,$data);
        $return['data'] = [];
        $return['item'] = [];
        $return['origin'] = $data;
        foreach ($data as $key => $value) {
            $return['item'][] = $value['date'];
            $return['data'][] = $value['value'];
        }
        return $this->responseOk('access success',$return);
    }

    public function analysis(Request $request)
    {

    }
    protected function formatData($start,$end,$type,$data)
    {
        if($type=='day'){
            $days = $start->diffInDays($end, false);
            for ($i=0; $i < $days; $i++) { 
                $date = $start->addDays(1)->toDateString();
                $val = 0;
                foreach ($data as $key => $value) {
                    if($value['date']==$date){
                        $val = $value['value'];
                    }
                }
                $tempData['date'] = $date;
                $tempData['value'] = $val;
                $newData[] = $tempData;
            }
        }elseif ($type=='week') {
            $day = $start;
            while ($day->lt($end)) {
                $week = $day->weekOfYear-1;
                $year = $day->year;
                $val = 0;
                $date = $day->startOfWeek()->toDateString();
                foreach ($data as $key => $value) {
                    if($value['date']==$year.'-'.$week){
                        $val = $value['value'];
                    }
                }
                $tempData['date'] = $date;
                $tempData['value'] = $val;
                $newData[] = $tempData;
                $day = $start->addWeeks(1);
            }
        }elseif ($type=='hour') {
            // $newData = $data;
            for ($i=0; $i < 24; $i++) { 
                $date = $i;
                $val = 0;
                foreach ($data as $key => $value) {
                    if($value['date']==$i){
                        $val = $value['value'];
                    }
                }
                $tempData['date'] = $date;
                $tempData['value'] = $val;
                $newData[] = $tempData;
            }
        }
        return $newData;
    }
}