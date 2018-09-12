<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingEventImageFile extends Model
{
    use SoftDeletes;

    protected $table = 'MarketingEventImageFile';

    public $primaryKey ='seq';
    
    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'client_name',
        'name',
        'extension',
        'mine_type',
        'size',
        'full_path',
        'url',
        'image_width',
        'image_height',
    ];
}
