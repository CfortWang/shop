<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopEvent extends Model
{
    use SoftDeletes;

    protected $table = 'ShopEvent';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [];
}

            