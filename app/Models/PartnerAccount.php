<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerAccount extends Model
{
    use SoftDeletes;

    protected $table = 'PartnerAccount';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'name',
        'id',
        'password',
        'email',
        'gender',
        'phone_num',
        'is_cert_phone_num',
        'bank',
        'bank_account',
        'bank_account_owner',
        'total_record',
        'reserved_point_in',
        'point',
        'total_point_in',
        'total_point_out',
        'status',
        'last_login_at',
        'partner_level',
        'recommender',
    ];

    public function salesPartners()
    {
        return $this->hasMany('App\Models\SalesPartner', 'partner_account', 'seq');
    }
}
