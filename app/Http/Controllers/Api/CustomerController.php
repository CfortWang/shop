<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Helpers\SendCodeHelper;
use Validator;
use Hash;
use App\Models\Buyer;
use App\Models\UserScanLog;
use App\Models\PhoneNumCertification;

class LoginController extends Controller
{
    public function __construct()
    {
    }
    public function scannedUserList(Request $request){
        $seq = $request->session()->get('buyer.seq');
        dd($seq);
        $offset = $request->start;
        $limit = $request->length;
        $searchValue = $request->search['value'];
        $orderColumnsNo = $request->order[0]['column'];
        $orderType = $request->order[0]['dir'];
        $columnArray = array('id','nickname','gender','q35package_code','created_at');
        $items = UserScanLog::where('buyer',$seq);
        $recordsTotal = $items->count();
        if (!empty($request->search['value'])) {
            $items = $items->where(function ($query) use ($searchValue) {
                $query
                ->where('user_phone_num', $searchValue);
            });
        }
        $recordsFiltered = $items->count();
        $items = $items->select('user_phone_num', 'user_name','created_at','q35code_code','q35package_code')
                ->orderBy($columnArray[$orderColumnsNo], $orderType)
                ->offset($offset)
                ->limit($limit)
                ->get();
        return $this->response4DataTables($items, $recordsTotal, $recordsFiltered);
    }
    public function code(Request $request)
    {
        $input = Input::only('phone','password','code','repeatPassword');

        $validator = Validator::make($input, [
            'phone'           => 'required',
            'code'            => 'required',
            'password'        => 'required',
            'repeatPassword'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('Bad Request');
        }
        $loginID  = $request->input('phone');
        $loginPW = $request->input('password');
        $buyer = Buyer::where('rep_phone_num', $loginID)->first();
        if (empty($buyer)){
            return $this->responseBadRequest('ID can not be find.', 101);
        } 
        if (!Hash::check($loginPW, $buyer->password)){
            return $this->responseBadRequest('Incorrect Password', 102);
        }
        $request->session()->put('buyer.seq', $buyer->seq);
        $request->session()->put('buyer.id', $buyer->rep_phone_num);
        return $this->responseOk('access success');
    }

   
}
