<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Q35Sales extends Model
{
    use SoftDeletes;

    protected $table = 'Q35Sales';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'sales_partner_type',
        'quantity',
        'total_sales_price',
        'payment_type',
        'refund_ment',
        'commission_status',
        'status',
        'paid_at',
        'refund_requested_at',
        'refund_completed_at',
        'sales_partner',
        'buyer',
    ];

        /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['buyerID', 'salesPartner'];

    /**
     * Get the user associated with the document.
     */
    public function buyerID()
    {
        return $this->hasOne('App\Models\Buyer', 'seq', 'buyer');
    }

    /**
     * Get the user associated with the document.
     */
    public function salesPartner()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'sales_partner');
    }
}
