<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopStamp extends Model
{
    use SoftDeletes;

    protected $table = 'ShopStamp';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [];
}

            