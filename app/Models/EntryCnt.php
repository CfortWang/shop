<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntryCnt extends Model
{
    use SoftDeletes;

    /**
     * 모델에서 사용되는 데이터베이스 테이블 이름.
     *
     * @var string
     */
    protected $table = 'EntryCnt';

    public $primaryKey ='seq';
    /**
     * The attributes that are not mass assignable.
     * [구글번역] 대량 할당할 수 없는 속성.
     * [김무진] 왜 대량인지는 모르겠다.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * 입력가능한 필드들
     *
     * @var array
     */
    protected $fillable = [
        'round_id',
        'user_id',
        'round_num',
        'entry_cnt',
    ];

    /**
     * 이 랭킹 정보를 가진 유저를 가져오거라. 알았다.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
