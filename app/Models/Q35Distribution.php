<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Q35Distribution extends Model
{
    use SoftDeletes;

    protected $table = 'Q35Distribution';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'hq_status',
        'provider_status',
        'distributor_status',
        'agency_status',
        'seller_status',
        'status',
        'hq_out_at',
        'provider_in_at',
        'provider_out_at',
        'distributor_in_at',
        'distributor_out_at',
        'agency_in_at',
        'agency_out_at',
        'seller_in_at',
        'sold_at',
        'q35package',
        'provider',
        'distributor',
        'agency',
        'seller',
        'buyer',
        'q35sales',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['pkg'];

    /**
     * Get the user associated with the document.
     */
    public function pkg()
    {
        return $this->hasOne('App\Models\Q35Package', 'seq', 'q35package');
    }
}
