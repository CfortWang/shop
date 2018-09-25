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
   //积分列表
    public function scoreList(Request $request)
    {
        $seq = $request->session()->get('buyer.seq');
        $offset = $request->start;
        $limit = $request->length;
        $searchValue = $request->search['value'];
        $orderColumnsNo = $request->order[0]['column'];
        $orderType = $request->order[0]['dir'];

        $columnArray = array('type', 'signed_point', 'remain_point', 'created_at');

        $items = BuyerPoint::where('buyer', $seq);
        
        $recordsTotal = $items->count();
        
        if (!empty($request->search['value'])) {
            $items = $items->where(function ($query) use ($searchValue) {
                $query
                ->where('type', 'like', '%'.$searchValue.'%')
                ->orWhere('signed_point', 'like', '%'.$searchValue.'%')
                ->orWhere('remain_point', 'like', '%'.$searchValue.'%');
            });
        }

        $recordsFiltered = $items->count();
        $items = $items->select(
                    'type as description',
                    'signed_point',
                    'remain_point',
                    'created_at',
                    'seq'
                )
                ->orderBy($columnArray[$orderColumnsNo], $orderType)
                ->offset($offset)
                ->limit($limit)
                ->get();
        
        // $salesPartner = SalesPartner::with('partnerAccount')->where('seq', $buyer->sales_partner)->first();
        return $this->response4DataTables($items, $recordsTotal, $recordsFiltered);
    }
    //账号基本信息
    public function detail(Request $request)
    {
        // $seq = $request->session()->get('buyer.seq');
        $seq=11;
        $AccountInfoDetail= Buyer::where('seq', $seq)
        // ->join('Bank as B', 'B.seq', '=', 'Buyer.bank')
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
        $PartnerID = PartnerAccount::find($AccountInfoDetail->sales_partner);
        if (empty($AccountInfoDetail)) {
            return $this->responseNotFound('There is no buyer.');
        }
        return $this->responseOK('Success.', [$AccountInfoDetail, $PartnerID]);
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
        $data = Bank::select('seq', 'name_'.$lang.' as name')->where('name_'.$lang,'!=',null)->orderBy('seq', 'asc')->get();
        return $this->responseOk('',$data);
    }

}
