<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BuyerCashOutRequest extends Model
{


    protected $table = 'BuyerCashOutRequest';
    protected $primaryKey = 'seq';

    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'seq',
        'amount',
        'bank_name',
        'account_holder',
        'account_number',
        'status',
        'remark',
        'created_at',
        'updated_at',
        'deleted_at',
        'rejected_at',
        'deposited_at',
        'buyer',
        'bank',
        'buyer_point'
     
    ];

    public static function getTableColumns() {
        list($cols, $values) = array_divide((new static)->first()->toArray());
        return $cols;
    }

}
