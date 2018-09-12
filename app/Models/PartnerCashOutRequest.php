<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PartnerCashOutRequest extends Model
{


    protected $table = 'PartnerCashOutRequest';
    protected $primaryKey = 'seq';

    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'seq',
        'amount',
        'bank_name',
        'account_hoder',
        'account_number',
        'status',
        'remark',
        'created_at',
        'updated_at',
        'deleted_at',
        'rejected_at',
        'deposited_at',
        'partner',
        'bank',
        'partner_point'
     
    ];

    public static function getTableColumns() {
        list($cols, $values) = array_divide((new static)->first()->toArray());
        return $cols;
    }

}
