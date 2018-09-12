<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPartnerType extends Model
{
    protected $table = 'SalesPartnerType';

    protected $fillable = [
        'name_zh',
        'name_en',
        'name_ko',
        'name_ja',
        'type',
        'min_premium',
        'sale_q35pkg_cnt',
    ];
}
