<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrouponProduct extends Model
{
    use SoftDeletes;

    protected $table = 'groupon_product';

    protected $guarded = [
        'id',
    ];

    public $primaryKey ='id';

    protected $fillable = [];
}
