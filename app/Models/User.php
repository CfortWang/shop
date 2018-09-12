<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 모델에서 사용되는 데이터베이스 테이블 이름.
     *
     * @var string
     */
    protected $table = 'User';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nickname',
        'gender',
        'birthday',
        'point',
        'ticket_cnt'
    ];

    public $primaryKey ='seq';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['phoneCountry'];

    /**
     * Get the user associated with the document.
     */
    public function phoneCountry()
    {
        return $this->hasOne('App\Models\Country', 'seq', 'phone_country');
    }

    /**
     * 사용자가 가지고 있는 소셜 계정을 가져옵니다.
     */
    public function social_user()
    {
        return $this->hasOne('App\Models\SocialUser');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     if($value != null){
    //       return Carbon::createFromTimestamp(strtotime($value))
    //         //   ->timezone(session('tz'))
    //           ->toDateTimeString()
    //       ;
    //     }
    // }

    // public function getLastLoginAtAttribute($value)
    // {
    //     if($value != null){
    //       return Carbon::createFromTimestamp(strtotime($value))
    //         //   ->timezone(session('tz'))
    //           ->toDateTimeString()
    //       ;
    //     }
    // }
}
