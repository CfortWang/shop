<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendType extends Model
{
    protected $table = 'RecommendType';

    protected $fillable = [
        'provider_percentage',
        'distributor_percentage',
        'agency_percentage',
        'seller_percentage',
    ];
}
