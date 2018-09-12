<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerReservedPoint extends Model
{
    use SoftDeletes;

    protected $table = 'PartnerReservedPoint';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [
        'total_point',
        'sales_point',
        'recommend_point',
        'remain_point',
        'period',
        'remain_period',
        'point',
        'status',
        'partner_account',
        'sales_partner',
    ];
}

            