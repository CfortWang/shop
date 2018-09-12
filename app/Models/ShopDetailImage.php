<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopDetailImage extends Model
{
    use SoftDeletes;

    protected $table = 'ShopDetailImage';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    protected $fillable = [
        'order_num',
        'created_at',
        'updated_at',
        'deleted_at',
        'buyer',
        'shop_image_file'
    ];

    /**
     * Get the user associated with the document.
     */
    public function detailImage()
    {
        return $this->hasOne('App\Models\ShopImageFile', 'seq', 'shop_image_file');
    }
}

            