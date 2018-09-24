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
        $data[2] = $this->getAge($orign);
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

    protected function getAge($orign)
    {
        $arnge = ['0-10','10-20','20-30','30-40','40-50','50-60','60-70','80_90','90以上'];
        $unknown['name'] = '未知';
        $unknown['value'] = 0;
        foreach ($orign as $key => $value) {
            if(isset($value['birthday'])){
                $year = Carbon::parse($value['birthday']);
                $different = (Carbon::now()->year - $year->year)%10;
                if($different>8){
                    $different = 8;
                }
                $data[$different]['name'] = $arnge[$different];
                $data[$different]['value'] = isset($data[$different]['value'])?$data[$different]['value']+1:1;
            }else{
                $unknown['value'] = $unknown['value']+1;
            }
        }
        $data = array_merge($data);
        $data[] = $unknown;
        $return['title'] = '年龄分布';
        $return['data'] = $data;
        $return['item'] = ['0-10','80-90','90以上','未知'];
        return $return;
    }

    protected function getMarrige($orign)
    {
        $no['name'] = '未婚';
        $no['value'] = 0;
        $married['name'] = '已婚';
        $married['value'] = 0;
        $loving['name'] = '热恋中';
        $loving['value'] = 0;
        $unknown['name'] = '未知';
        $unknown['value'] = 0;
        foreach ($orign as $key => $value) {
            if(!isset($value['is_married'])){
                $value['is_married'] = -1;
            }
            switch ($value['is_married']) {
                case '0':
                    $no['value'] = $no['value']+1;
                    break;
                case '1':
                   $married['value'] = $married['value']+1;
                    break;
                case '2':
                   $loving['value'] = $loving['value']+1;
                    break;
                default:
                    $unknown['value'] = $unknown['value']+1;
                    break;
            }
        }
        if($no['value']){
            $item[] = '未婚';
            $orignData[] = $no;
        }
        if($married['value']){
            $item[] = '已婚';
            $orignData[] = $married;
        }
        if($loving['value']){
            $item[] = '热恋中';
            $orignData[] = $loving;
        }
        if($unknown['value']){
            $item[] = '未知';
            $orignData[] = $unknown;
        }
        $data['title'] = '婚姻状态';
        $data['data'] = $orignData;
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

    public function active(Request $request)
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
    public function silence(Request $request)
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

    public function frequency(Request $request)
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
 
 
}