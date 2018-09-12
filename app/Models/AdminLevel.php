<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminLevel extends Model
{
    use SoftDeletes;

    protected $table = 'AdminLevel';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [

    ];
}
