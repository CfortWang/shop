<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Q35Package extends Model
{
    use SoftDeletes;

    protected $table = 'Q35Package';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'code',
        'type',
        'prefix',
        'total_cnt',
        'used_cnt',
        'sheet_cnt',
        'unit_accum',
        'total_accum',
        'unit_print_price',
        'unit_profit',
        'prime_price',
        'min_sales_price',
        'sales_price',
        'status',
        'printing_at',
        'in_at',
        'out_at',
        'sold_at',
        'q35sales',
        'q35contract',
        'start_q35code',
        'end_q35code',
    ];
}
