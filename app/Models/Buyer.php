<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends Model
{
    use SoftDeletes;

    protected $table = 'Buyer';
    protected $primaryKey = 'seq';

    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'id',
        'password',
        'code',
        'name',
        'phone_num',
        'is_cert_phone_num',
        'rep_name',
        'rep_phone_num',
        'bank_account',
        'bank_account_owner',
        'address_detail',
        'lat',
        'lng',
        'homepage_url',
        'branch_name',
        'description',
        'point',
        'total_point_in',
        'total_point_out',
        'last_discount_pkg_price',
        'user_like_cnt',
        'open_time',
        'close_time',
        'open_close_remark',
        'stamp_status',
        'status',
        'country',
        'province',
        'city',
        'area',
        'sales_partner',
        'buyer_category',
        'bank',
        'shop_logo_image_file'
    ];

    public static function getTableColumns() {
        list($cols, $values) = array_divide((new static)->first()->toArray());
        return $cols;
    }

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // protected $with = ['salesPartner'];

    /**
     * Get the user associated with the document.
     */
    public function salesPartner()
    {
        return $this->hasOne('App\Models\SalesPartner', 'seq', 'sales_partner');
    }

    public function logoImage()
    {
        return $this->hasOne('App\Models\ShopImageFile', 'seq', 'shop_logo_image_file');
    }
}
