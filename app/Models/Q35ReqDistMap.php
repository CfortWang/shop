<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Q35ReqDistMap extends Model
{
    protected $table = 'Q35ReqDistMap';

    protected $fillable = [
        'q35request',
        'q35distribution'
    ];
}
