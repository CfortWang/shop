<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopAD extends Model
{
    use SoftDeletes;

    protected $table = 'ShopAD';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [
        'title',
        'type',
        'view_cnt',
        'landing_url',
        'status',
        'buyer',
        'shop_image_file'
    ];
}

            