<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Drawing extends Model
{
    use SoftDeletes;

    /**
     * 모델에서 사용되는 데이터베이스 테이블 이름.
     *
     * @var string
     */
    protected $table = 'Drawing';

    /**
     * The attributes that are not mass assignable.
     * [구글번역] 대량 할당할 수 없는 속성.
     * [김무진] 왜 대량인지는 모르겠다.
     *
     * @var array
     */
    protected $guarded = [
        'seq',
    ];

    public $primaryKey ='seq';

    /**
     * 입력가능한 필드들
     *
     * @var array
     */
    protected $fillable = [
        'point',
        'drawing_num',
        'start_at',
        'end_at',
        'status',
    ];

    public function getCreatedAtAttribute($value)
    {
        if($value != null){
          return Carbon::createFromTimestamp(strtotime($value))
              ->timezone(session('tz'))
              ->toDateString()
          ;
        }
    }

    public function getStartAtAttribute($value)
    {
        if($value != null){
          return Carbon::createFromTimestamp(strtotime($value))
              ->timezone(session('tz'))
              ->toDateTimeString()
          ;
        }
    }

    public function getEndAtAttribute($value)
    {
        if($value != null){
          return Carbon::createFromTimestamp(strtotime($value))
              ->timezone(session('tz'))
              ->toDateString()
          ;
        }
    }
}
