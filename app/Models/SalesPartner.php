<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPartner extends Model
{
    use SoftDeletes;

    protected $table = 'SalesPartner';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'type',
        'premium',
        'sale_q35pkg_cnt',
        'dist_q35pkg_cnt',
        'curr_q35pkg_cnt',
        'sales_comm_status',
        'recommend_comm_status',
        'status',
        'premium_paid_at',
        'provider',
        'distributor',
        'agency',
        'country',
        'province',
        'city',
        'area',
        'partner_account',
        'recommender',
        'partner_level',
    ];

    public function partnerAccount()
    {
        return $this->belongsTo('App\Models\PartnerAccount', 'partner_account', 'seq');
    }
}
