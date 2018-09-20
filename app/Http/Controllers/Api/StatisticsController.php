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
use App\Models\User;
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
        $seq = 1;
        $orign = UserScanLog::where('buyer',$seq)
            ->leftJoin('User as a','a.seq','=','UserScanLog.user')
            // ->where('created_at', '<=', $endDate)
            // ->where('created_at', '>=', $startDate)
            ->select('a.gender','a.birthday','a.is_married')
            ->distinct()
            ->get();
            
        $data[1] = $this->getGender($orign);
        $data['new'] = $this->getGender($orign);
        $data[2] = $this->getGender($orign);
        $data[3] = $this->getMarrige($orign);
        $data['time'] = $this->getGender($orign);
        $data['age'] = $this->getGender($orign);
        return $this->responseOk('access success',$data);
    }

    protected function getGender($orign)
    {
        $female['name'] = '女';
        $female['value'] = 0;
        $male['name'] = '男';
        $male['value'] = 0;
        $unknown['name'] = '未知';
        $unknown['value'] = 0;
        foreach ($orign as $key => $value) {
            if(!isset($value['gender'])){
                $value['gender'] = -1;
            }
            switch ($value['gender']) {
                case 'female':
                    $female['value'] = $female['value']+1;
                    break;
                case 'male':
                    $male['value'] = $male['value']+1;
                    break;
                default:
                    $unknown['value'] = $unknown['value']+1;
                    break;
            }
        }
        if($female['value']){
            $item[] = '女';
            $orignData[] = $female;
        }
        if($male['value']){
            $item[] = '男';
            $orignData[] = $male;
        }
        if($unknown['value']){
            $item[] = '未知';
            $orignData[] = $unknown;
        }
        $data['title'] = '性别比例';
        $data['data'] = $orignData;
        $data['item'] = $item;
        return $data;
    }

    protected function getAge()
    {
        // $orign = User::GroupBy('gender')->get([
        //     'gender',
        //     DB::raw('COUNT(seq) as value'),
        // ]);
        // foreach ($orign as $key => $value) {
        //     switch ($value['gender']) {
        //         case 'female':
        //             $female = '女';
        //             $item[] = $female;
        //             $orign[$key]['name'] = $female;
        //             break;
        //         case 'male':
        //             $male = '男';
        //             $item[] = $male;
        //             $orign[$key]['name'] = $male;
        //             break;
        //         default:
        //             $name = '未知';
        //             $item[] = $name;
        //             $orign[$key]['name'] = $name;
        //             break;
        //     }
        // }
        // $data['title'] = '性别比例';
        // $data['data'] = $orign;
        // $data['item'] = $item;
        // return $data;
        for ($i=0; $i < 10; $i++) { 
            // SELECT * from users where DATEDIFF(now(),Ubirthday) <18 or DATEDIFF(now(),Ubirthday)>25
            $start = intval($i*10);
            if($i==0){
                $orign[] = User::whereRaw('DATEDIFF(now(),birthday) <'.$start)->count(); 
            }elseif($i==9){
                $orign[] = User::whereRaw('DATEDIFF(now(),birthday) >'.$start)->count(); 
            }else{
                $orign[] = User::whereRaw('DATEDIFF(now(),birthday) >'.$start.' and DATEDIFF(now(),birthday) <'.($start+10))->count(); 
            }
            // $orign[] = User::whereRaw('DATEDIFF(now(),birthday) >'.$start.' and DATEDIFF(now(),birthday) <'.($start+10))->count();
        }
        return $orign;
    }

    protected function getMarrige($orign)
    {
        $female['name'] = '女';
        $female['value'] = 0;
        $married['name'] = '已婚';
        $married['value'] = 0;
        $loving['name'] = '已婚';
        $loving['value'] = 0;
        $unknown['name'] = '未知';
        $unknown['value'] = 0;

        // if($female['value']){
        //     $item[] = '女';
        //     $orignData[] = $female;
        // }
        // if($male['value']){
        //     $item[] = '男';
        //     $orignData[] = $male;
        // }
        // if($unknown['value']){
        //     $item[] = '未知';
        //     $orignData[] = $unknown;
        // }
        foreach ($orign as $key => $value) {
            switch ($value['is_married']) {
                case '0':
                    $female = '未婚';
                    $item[] = $female;
                    $orign[$key]['name'] = $female;
                    break;
                case '1':
                    $male = '已婚';
                    $item[] = $male;
                    $orign[$key]['name'] = $male;
                    break;
                case '2':
                    $male = '热恋中';
                    $item[] = $male;
                    $orign[$key]['name'] = $male;
                    break;
                default:
                    $name = '未知';
                    $item[] = $name;
                    $orign[$key]['name'] = $name;
                    break;
            }
        }
        $data['title'] = '婚姻状态';
        $data['data'] = $orign;
        $data['item'] = $item;
        return $data;
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