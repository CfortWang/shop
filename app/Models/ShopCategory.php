<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopCategory extends Model
{
    use SoftDeletes;

    protected $table = 'ShopCategory';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [];
}

            