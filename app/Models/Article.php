<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'Article';
    public $primaryKey ='seq';

    protected $noticeBoardSeq = 1;

    protected $guarded = [
        'seq',
    ];

    /**
     * 입력가능한 필드들
     *
     * @var array
     */
    protected $fillable = [
        'title_zh',
        'title_en',
        'title_ko',
        'title_ja',
        'content_zh',
        'content_en',
        'content_ko',
        'content_ja',
        'board',
        'admin',
    ];

    protected function scopeNotice($query)
    {
        return $query->where('board', $this->noticeBoardSeq);
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin', 'seq');
    }
}
