<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;

use App\Models\Buyer;
use App\Models\SalesPartner;
use App\Models\BuyerPoint;
use App\Models\Bank;
use App\Models\PartnerAccount;



class AccountInfoController extends Controller
{
     //账号基本信息
    public function detail(Request $request)
    {
        // $seq = $request->session()->get('buyer.seq');
        $seq=14;
        $data= Buyer::where('seq', $seq)
        // ->join('PartnerAccount as p', 'p.seq', '=', 'Buyer.sales_partner')
        ->select([
            'id',
            'rep_name',
            'rep_phone_num',
            'point',
            'bank_account',
            'bank_account_owner',
            'bank',
            'sales_partner'
        ])
        ->first();
        $PartnerAccount=PartnerAccount::where('seq',$data->sales_partner)->select('id')->first();
        $list['rep_name'] =$data['rep_name'];
        $list['rep_phone_num'] =$data['rep_phone_num'];
        $list['bank'] =$data['bank'];
        $list['bank_account'] =$data['bank_account'];
        $list['bank_account_owner'] =$data['bank_account_owner'];
        $list['partner_id'] =$PartnerAccount['id'];
        if (empty($data)) {
            return $this->responseNotFound('There is no buyer.');
        }
        return $this->responseOK('Success.', $list);
    }
    //积分列表
    public function scoreList(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
        $seq=14;
        $limit = $request->input('limit',20);
        $page = $request->input('page',1);
        $searchValue = $request->input('search');
        $items = BuyerPoint::where('buyer', $seq);
        $count = $items->count();
        if (!empty( $searchValue)) {
            $items = $items->where(function ($query) use ($searchValue) {
                $query
                ->where('type', 'like', '%'.$searchValue.'%')
                ->orWhere('signed_point', 'like', '%'.$searchValue.'%')
                ->orWhere('remain_point', 'like', '%'.$searchValue.'%');
            });
        }
        $items = $items->select(
                    'type as description',
                    'signed_point',
                    'remain_point',
                    'created_at',
                    'seq'
                )
                ->limit($limit)
                ->offset(($page-1)*$limit) 
                ->get();
        
        return $this->response4DataTables($items,$count,1);
    }
    public function modify(Request $request){
        $seq = $request->session()->get('buyer.seq');
        $input = Input::only([  
            'rep_name',
            'bank_seq',
            'bank_account',
            'bank_account_owner',
            ]
        );
        $AccountInfoDetail = Buyer::find($seq);
        if(empty($AccountInfoDetail)){
            return $this->responseNotFound('No data','','');
        }
        $AccountInfoDetail->rep_name = $request->input('rep_name');
        $AccountInfoDetail->bank = $request->input('bank_seq');
        $AccountInfoDetail->bank_account = $request->input('bank_account');
        $AccountInfoDetail->bank_account_owner = $request->input('bank_account_owner');
        
        $AccountInfoDetail->save();
        return $this->responseOK('정보가 수정되었습니다.',$AccountInfoDetail);
    }

    public function bankList(Request $request){
        $lang = $request->session()->get('bw.locale');
        $lang="zh";
        $data = Bank::select('seq', 'name_'.$lang.' as name')->where('name_'.$lang,'!=',null)->orderBy('seq', 'asc')->get();
        return $this->responseOk('',$data);
    }

}
