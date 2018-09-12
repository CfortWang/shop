<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MarketingEventWin extends Model
{
    use SoftDeletes;

    protected $table = 'MarketingEventWin';

    public $primaryKey ='seq';
    
    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'delivery_num',
        'status',
        'requested_at',
        'rejected_at',
        'readied_at',
        'deliveried_at',
        'marketing_event',
        'marketing_event_gift',
        'user'
    ];
}
