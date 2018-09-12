<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    protected $table = 'Province';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [];
}
