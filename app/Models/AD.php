<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class AD extends Model
{
    use SoftDeletes;

    protected $table = 'AD';

    public $primaryKey ='seq';
    
    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'title',
        'view_cnt',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'ad_image_file',
        'ad_video_file',
    ];

    public function adImageFile()
    {
        return $this->hasOne('App\Models\ADImageFile', 'seq', 'ad_image_file');
    }
}
