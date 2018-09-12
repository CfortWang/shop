<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerPoint extends Model
{
    use SoftDeletes;

    protected $table = 'PartnerPoint';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        
    ];
}
