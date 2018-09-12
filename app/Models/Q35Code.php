<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Q35Code extends Model
{
    use SoftDeletes;

    /**
    * 모델에서 사용되는 데이터베이스 테이블 이름.
    *
    * @var string
    */
    protected $table = 'Q35Code';

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
        'entry_cnt',
    ];

    public function getCreatedAtAttribute($value)
    {
        if($value != null){
            return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(session('tz'))
            ->toDateTimeString()
            ;
        }
    }

    public function getActivatedAtAttribute($value)
    {
        if($value != null){
            return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(session('tz'))
            ->toDateTimeString()
            ;
        }
    }

    public static function getTableColumns() {
        list($cols, $values) = array_divide((new static)->first()->toArray());
        return $cols;
    }
}
