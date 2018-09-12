<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserScanLog extends Model
{
    use SoftDeletes;

    protected $table = 'UserScanLog';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [];
}

            