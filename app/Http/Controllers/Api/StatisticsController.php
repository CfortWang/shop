<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendCodeHelper;
use Validator;
use Hash;
use App;

use Carbon\Carbon;
use App\Models\UserScanLog;
use App\Models\User;
use App\Models\PhoneNumCertification;

class StatisticsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->buyer_id = $request->session()->get('buyer.seq');
    }

    public function all(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
       
         $return['tomorrowNew'] = UserScanLog::where('UserScanLog.buyer',$seq)
            ->leftJoin('User as a','a.seq','=','UserScanLog.user')
            ->where('UserScanLog.created_at','>',Carbon::now()->yesterday())
            ->where('a.created_at','>',Carbon::now()->yesterday())
            ->distinct('user')
            ->count('user');
        $return['all'] = UserScanLog::where('buyer',$seq)
            ->distinct('user')
            ->count('user');
         $return['tomorrowAll'] = UserScanLog::where('buyer',$seq)
            ->where('created_at','>',Carbon::now()->yesterday())
            ->distinct('user')
            ->count('user');
        return $this->responseOk('access success',$return);
    }

    public function newCustomer(Request $request)
    {
        $seq  = $request->session()->get('buyer.seq');
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
                DB::raw('COUNT(distinct user) as value'),
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
        $seq = $request->session()->get('buyer.seq');
        $orign = UserScanLog::where('UserScanLog.buyer',$seq)
            ->leftJoin('User as a','a.seq','=','UserScanLog.user')
            ->select('a.gender','a.birthday','a.is_married','a.created_at','UserScanLog.created_at as create_at_1')
            ->groupBy('a.gender','a.birthday','a.is_married','a.created_at')
            ->orderBy('id','desc')
            ->get();
        $data[1] = $this->getGender($orign);
        $data[2] = $this->getAge($orign);
        $data[3] = $this->getMarrige($orign);
        $data[4] = $this->getNew($orign);
        $data[5] = $this->getTime($orign);
        $data[6] = $this->getProvince($orign);
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
        $orignData = [];
        $item = [];
        $item[] = '女';
        $orignData[] = $female;
        $item[] = '男';
        $orignData[] = $male;
        $item[] = '未知';
        $orignData[] = $unknown;
        $data['title'] = '性别比例';
        $data['data'] = $orignData;
        $data['item'] = $item;
        return $data;
    }

    protected function getNew($orign)
    {
        $new['name'] = '新用户';
        $new['value'] = 0;
        $old['name'] = '旧用户';
        $old['value'] = 0;
        foreach($orign as $key => $value){
            if((strtotime($value['created_at_1'])-strtotime($value['created_at']))<24*60*60){
                $new['value'] = $new['value'] + 1;
            }else{
                $old['value'] = $old['value'] + 1;
            }
        }
        $data[] = $new;
        $data[] = $old;
        $item[] = '新用户';
        $item[] = '旧用户';
        $return['title'] = '新用户比例';
        $return['item'] = $item;
        $return['data'] = $data;
        return $return;

    }

    protected function getTime()
    {
        $seq = $this->buyer_id;
        $sql = DB::raw('DATE_FORMAT(created_at,"%H") as name');
        $data = UserScanLog::where('UserScanLog.buyer',$seq)
            ->groupBy('name')
            ->orderBy('name', 'ASC')
            ->get([
                $sql,
                DB::raw('COUNT(user) as value'),
            ]);
        $title= '时间分布';
        $item = [];
        foreach($data as $key => $value){
            $item[] = ($value['name']+8)%24;
            $data[$key]['name'] = ($data[$key]['name']+8)%24;
        }
        $return['title'] = '时间分布';
        $return['data'] = $data;
        $return['item'] = $item;
        return $return;
    }

    protected function getProvince()
    {
        $seq = $this->buyer_id;
        $data = UserScanLog::where('UserScanLog.buyer',$seq)
            ->leftJoin('User as u','u.seq','=','UserScanLog.user')
            ->leftJoin('Province as p','p.seq','=','u.province')
            ->groupBy('p.name')
            ->distinct('UserScanLog.user')
            ->get([
                'p.name',
                'UserScanLog.user',
                DB::raw('COUNT(UserScanLog.user) as value'),
            ]);
        $item = [];
        foreach($data as $key => $value){
            if($value['name']){
                $item[] = $value['name'] ;
            }else{
                $data[$key]['name'] = '未知';
                $item[] = '未知';
            }
        }
        $return['title'] = '地域分布';
        $return['data'] = $data;
        $return['item'] = $item;
        return $return;
    }

    protected function getAge($orign)
    {
        $arnge = ['0-10','10-20','20-30','30-40','40-50','50-60','60-70','80-90','90以上'];
        $unknown['name'] = '未知';
        $unknown['value'] = 0;
        $item = [];
        $data = [];
        foreach ($orign as $key => $value) {
            if(isset($value['birthday'])){
                $year = Carbon::parse($value['birthday']);
                $different = (Carbon::now()->year - $year->year)/10;
                if($different>8){
                    $different = 8;
                }
                $data[$different]['name'] = $item[] = $arnge[$different];
                $data[$different]['value'] = isset($data[$different]['value'])?$data[$different]['value']+1:1;
            }else{
                if($unknown['value']==0){
                    $item[] = '未知';
                }
                $unknown['value'] = $unknown['value']+1;
            }
        }
        $data = array_merge($data);
        $data[] = $unknown;
        $return['title'] = '年龄分布';
        $return['data'] = $data;
        $return['item'] = $item;
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
        $orignData = [];
        $item = [];
        $item[] = '已婚';
        $orignData[] = $married;
        $item[] = '热恋中';
        $orignData[] = $loving;
        $item[] = '未知';
        $orignData[] = $unknown;
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
                $val = 0;
                $date = $start->toDateString();
                foreach ($data as $key => $value) {
                    if($value['date']==$date){
                        $val = $value['value'];
                    }
                }
                $tempData['date'] = $date;
                $tempData['value'] = $val;
                $newData[] = $tempData;
                $start->addDays(1);
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
        $seq  = $request->session()->get('buyer.seq');
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
                DB::raw('COUNT(distinct user) as value'),
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
        $seq  = $request->session()->get('buyer.seq');
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
        $seq  = $request->session()->get('buyer.seq');
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

    public function list(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
        $type = $request->input('type');
        $startDate = Carbon::createFromFormat('Y-m-d',$request->input('startDate'));
        $endDate = Carbon::createFromFormat('Y-m-d',$request->input('endDate'));
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        switch ($type) {
            case 'frequency':
                $data = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at','>',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->groupBy('date')
                    ->select(DB::raw('Date(UserScanLog.created_at) as date'),DB::raw('COUNT(UserScanLog.user) as value'))
                    ->limit($limit)
                    ->offset(($page-1)*$limit)
                    ->get();
                $count = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at','>=',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->groupBy('date')
                    ->select(DB::raw('Date(UserScanLog.created_at) as date'),DB::raw('COUNT(UserScanLog.user) as value'))
                    ->get();
                break;
            
            default:
                $data = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at','>',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->groupBy('date')
                    ->select(DB::raw('Date(UserScanLog.created_at) as date'),DB::raw('COUNT(distinct UserScanLog.user) as value'))
                    ->limit($limit)
                    ->offset(($page-1)*$limit)
                    ->get();
                $count = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at','>=',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->groupBy('date')
                    ->select(DB::raw('Date(UserScanLog.created_at) as date'),DB::raw('COUNT(distinct UserScanLog.user) as value'))
                    ->get();
                break;
        }
        
            $count = count($count);
        $return['count'] = $count;
        if($type=='active'){
            foreach ($data as $key => $value) {
                $data[$key]['rate'] = rand(1,9)/10;
            }
        }
        $return['data'] = $data;
        return $this->responseOk('',$return);
    }

    public function detail(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $date = $request->input('date');
        $type = $request->input('type');
        $startDate = Carbon::createFromFormat('Y-m-d',$date);
        $date = $startDate;
        switch ($type) {
            case 'new':
                $startDate = $startDate->startOfDay()->toDateTimeString();
                $endDate = $date->addDay();
                $data = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->where('UserScanLog.created_at','>',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->select('a.seq','a.nickname','UserScanLog.created_at','UserScanLog.user')
                    ->limit($limit)
                    ->offset(($page-1)*$limit)
                    ->get();
                $count = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at','>',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->count();
                break;
            case 'silence':
                $startDate = $startDate->startOfDay()->toDateTimeString();
                $monthBefore = $date->subMonth();
                $data = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at', '<=', $monthBefore)
                    ->select('a.seq','a.nickname','UserScanLog.created_at')
                    ->limit($limit)
                    ->offset(($page-1)*$limit)
                    ->orderBy('created_at','desc')
                    ->get();
                $count = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at', '<=', $monthBefore)
                    ->count();
                break;
            case 'active':
                $startDate = $startDate->startOfDay()->toDateTimeString();
                $monthBefore = $date->subMonth();
                $data = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at', '<=', $monthBefore)
                    ->select('a.seq','a.nickname','UserScanLog.created_at')
                    ->limit($limit)
                    ->offset(($page-1)*$limit)
                    ->get();
                $count = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at', '<=', $monthBefore)
                    ->count();
                break;
            case 'frequency':
                $startDate = $startDate->startOfDay()->toDateTimeString();
                $endDate = $date->addDay();
                $data = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at','>',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->select('a.seq','a.nickname','UserScanLog.created_at')
                    ->limit($limit)
                    ->offset(($page-1)*$limit)
                    ->get();
                $count = UserScanLog::where('UserScanLog.buyer',$seq)
                    ->leftJoin('User as a','a.seq','=','UserScanLog.user')
                    ->where('UserScanLog.created_at','>',$startDate)
                    ->where('UserScanLog.created_at', '<=', $endDate)
                    ->count();
                break;
            default:
                break;
        }
        
        $return['count'] = $count;
        $return['data'] = $data;
        return $this->responseOk('',$return);
    }

}