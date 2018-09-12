<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Q35Contract extends Model
{
    use SoftDeletes;

    protected $table = 'Q35Contract';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'title',
        'quantity',
        'buyer_comm_status',
        'status',
        'activate_at',
        'done_at',
        'stop_at',
        'expire_at',
        'buyer',
        'country',
        'province',
        'city',
        'area',
    ];
}

            