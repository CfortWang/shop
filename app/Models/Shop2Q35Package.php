<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop2Q35Package extends Model
{
    use SoftDeletes;

    protected $table = 'Shop2Q35Package';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'type',
        'start_num',
        'end_num',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'buyer',
        'shop_event',
        'shop_ad',
        'q35package'
    ];
}
