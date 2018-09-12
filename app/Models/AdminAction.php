<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminAction extends Model
{
    use SoftDeletes;

    protected $table = 'AdminAction';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [

    ];

    protected $hidden = [

    ];
}
