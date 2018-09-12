<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MarketingEvent extends Model
{
    use SoftDeletes;

    protected $table = 'MarketingEvent';

    public $primaryKey ='seq';
    
    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'type',
        'title',
        'start_time',
        'end_time',
        'losing_img',
        'scan_cnt',
        'status',
        'country',
        'province',
        'losing_image_file',
    ];

    public function losingImageFile()
    {
        return $this->hasOne('App\Models\MarketingEventImageFile', 'seq', 'losing_image_file');
    }
}
