<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MarketingEventGift extends Model
{
    use SoftDeletes;

    protected $table = 'MarketingEventGift';

    public $primaryKey ='seq';

    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'start_time',
        'end_time',
        'img',
        'remark',
        'total_win',
        'win_cnt',
        'condition',
        'sun',
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'status',
        'marketing_event',
        'result_image_file',
        'detail_image_file',
        'type',
        'prize',
    ];

    public function resultImageFile()
    {
        return $this->hasOne('App\Models\MarketingEventImageFile', 'seq', 'result_image_file');
    }

    public function detailImageFile()
    {
        return $this->hasOne('App\Models\MarketingEventImageFile', 'seq', 'detail_image_file');
    }
}
