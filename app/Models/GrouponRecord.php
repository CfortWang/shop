<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrouponRecord extends Model
{
    use SoftDeletes;

    protected $table = 'groupon_record';

    protected $guarded = [
        'id',
    ];

    public $primaryKey ='id';

    protected $fillable = [];
}
