<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Q35PreSingleCode extends Model
{
    protected $table = 'Q35PreSingleCode';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'code',
        'url_code',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
