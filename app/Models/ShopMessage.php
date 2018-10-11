<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopMessage extends Model
{
    use SoftDeletes;

    protected $table = 'shop_message';

    public $primaryKey ='id';
    
    protected $guarded = [
        'id',
    ];

}
