<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CashOut extends Model
{


    protected $table = 'CashOut';
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
        'user',
        'bank'
     
    ];

    public static function getTableColumns() {
        list($cols, $values) = array_divide((new static)->first()->toArray());
        return $cols;
    }

}
