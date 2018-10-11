<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopMessageUser extends Model
{
    use SoftDeletes;

    protected $table = 'shop_message_user';

    public $primaryKey ='id';
    
    protected $guarded = [
        'id',
    ];

}
