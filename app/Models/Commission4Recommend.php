<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission4Recommend extends Model
{
    use SoftDeletes;

    protected $table = 'Commission4Recommend';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'recommender_type',
        'recommendee_type',
        'premium',
        'provider_comm',
        'distributor_comm',
        'agency_comm',
        'seller_comm',
        'status',
        'recommender',
        'recommendee',
        'provider',
        'distributor',
        'agency',
        'seller',
    ];
}
