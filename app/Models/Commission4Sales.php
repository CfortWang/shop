<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission4Sales extends Model
{
    use SoftDeletes;

    protected $table = 'Commission4Sales';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'dc_provider',
        'dc_distributor',
        'dc_agency',
        'dc_seller',
        'ac_provider',
        'ac_distributor',
        'ac_agency',
        'ac_seller',
        'status',
        'provider',
        'distributor',
        'agency',
        'seller',
        'buyer',
        'q35sales',
    ];
}
