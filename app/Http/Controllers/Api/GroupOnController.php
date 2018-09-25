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
use App\Models\GrouponProduct;
use App\Models\Groupon;
use App\Models\GrouponRecord;

class GroupOnController extends Controller
{
    public function __construct()
    {
        $this->buyer_id = 1;
    }

    public function list()
    {
        $buyer_id = $this->buyer_id;
        $product = GrouponProduct::where('buyer_id',$buyer_id)
            ->select('id','price','discounted_price','join_number','product_status','effective_day')
            ->get();
        foreach ($product as $key => $value) {
            $product[$key]['unused'] = 0;
            $product[$key]['used'] = 0;
            $data = Groupon::where('groupon.groupon_product_id',$value['id'])
                ->where('a.paid_status','>',0)
                ->leftJoin('groupon_record as a','a.groupon_id','=','groupon.id')
                ->select('a.paid_status','a.groupon_id')
                ->get();
                unset($group);
                foreach ($data as $k => $val) {
                    if($val['paid_status']==1){
                        $product[$key]['unused'] = $product[$key]['unused']+1;
                    }elseif ($val['paid_status']==2) {
                        $product[$key]['used'] = $product[$key]['used']+1;
                    }
                    $group[$val['groupon_id']] = 1;
                }
            $product[$key]['group'] = count($group);
        }
        return $this->responseOk('',$product);
    }

    public function create(Request $request)
    {
        $buyer_id = $this->buyer_id;
        $Input=Input::only('title','price','discounted_price','group_size','remark','rule','open_time','close_time','start_use_time','end_use_time','is_weekend','is_festival');
        
    }
}