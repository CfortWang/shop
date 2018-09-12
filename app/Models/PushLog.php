<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PushLog extends Model
{


    protected $table = 'PushLog';
    protected $primaryKey = 'seq';

    protected $guarded = [
        'seq',
    ];

    protected $fillable = [
        'seq',
        'user_list',
        'type',
        'sender',
        'title',
        'content',
        'ret_codee',
        'err_msg',
        'created_at',
        'update_at',
     
    ];

    public static function getTableColumns() {
        list($cols, $values) = array_divide((new static)->first()->toArray());
        return $cols;
    }

}
