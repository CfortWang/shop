<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Entry extends Model
{
    use SoftDeletes;

    /**
     * 모델에서 사용되는 데이터베이스 테이블 이름.
     *
     * @var string
     */
    protected $table = 'Entry';

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

    /**
     * 입력가능한 필드들
     *
     * @var array
     */
    protected $fillable = [
        'qr_code_seq',
        'round_seq',
        'user_seq',
        'country_seq',
        'province_seq',
        'city_seq',
        'area_seq',
        'is_qr_code_entry',
        'is_ticket_entry',
        'round_num',
        'num_1',
        'num_2',
        'num_3',
        'num_4',
        'num_5',
        'num_6',
        'num_7',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(session('tz'))
            ->toDateTimeString()
        ;
    }
}
