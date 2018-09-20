<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groupon extends Model
{
    use SoftDeletes;

    protected $table = 'groupon';

    protected $guarded = [
        'id',
    ];

    public $primaryKey ='id';

    protected $fillable = [];
}
