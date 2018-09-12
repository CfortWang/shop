<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopGift extends Model
{
    use SoftDeletes;

    protected $table = 'ShopGift';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [
        'name',
        'discount_type',
        'min_price',
        'discount_percent',
        'discount_price',
        'restriction',
        'remark',
        'expire_day',
        'status',
        'buyer',
        'shop_image_file'
    ];
}

            