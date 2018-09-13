<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *	@SWG\Definition(
 *		definition="PhoneNumCertification",
 *		required={"seq", "user"},
 *		@SWG\Property(property="seq", type="integer", format="int64", description="고유번호"),
 *		@SWG\Property(property="type", type="string", description="인증 타입", enum={"sign_up", "find_pw"}),
 *		@SWG\Property(property="calling_code", type="integer", description="국가코드"),
 *		@SWG\Property(property="phone_num", type="string", description="전화번호"),
 *		@SWG\Property(property="code", type="string", description="인증코드"),
 *		@SWG\Property(property="created_at", type="string", description="생성일시"),
 *		@SWG\Property(property="updated_at", type="string", description="수정일시"),
 *		@SWG\Property(property="deleted_at", type="string", description="삭제일시"),
 *		@SWG\Property(property="country", type="integer", format="int32", description="국가 고유번호"),
 *	),
 */

class PhoneNumCertification extends Model
{
    use SoftDeletes;

    protected $table = 'PhoneNumCertification';
    protected $primaryKey = 'seq';

    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'country',
        'phone_num',
        'code',
        'type',
        'calling_code',
    ];

}
