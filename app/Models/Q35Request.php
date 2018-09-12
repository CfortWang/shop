<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Q35Request extends Model
{
    use SoftDeletes;

    protected $table = 'Q35Request';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        's_req',
        'a_res',
        's_req_status',
        's_req_at',
        's_confirm_at',
        's_res_at',
        's_cancel_at',
        's_rereq_at',
        'a_req',
        'd_res',
        'a_req_status',
        'a_req_at',
        'a_confirm_at',
        'a_res_at',
        'a_cancel_at',
        'a_rereq_at',
        'd_req',
        'p_res',
        'd_req_status',
        'd_req_at',
        'd_confirm_at',
        'd_res_at',
        'd_cancel_at',
        'd_rereq_at',
        'p_req',
        'hq_res',
        'p_req_status',
        'p_req_at',
        'p_confirm_at',
        'p_res_at',
        'p_cancel_at',
        'p_rereq_at',
        'amount',
        'country',
        'province',
        'city',
        'area',
        'status'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['sReq', 'aRes', 'aReq', 'dRes', 'dReq', 'pRes', 'pReq', 'hqRes'];

    /**
     * Get the user associated with the document.
     */
    public function sReq()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 's_req');
    }
    public function aRes()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'a_res');
    }
    public function aReq()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'a_req');
    }
    public function dRes()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'd_res');
    }
    public function dReq()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'd_req');
    }
    public function pRes()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'p_res');
    }
    public function pReq()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'p_req');
    }
    public function hqRes()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'hq_res');
    }
}
