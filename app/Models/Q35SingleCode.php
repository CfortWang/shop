<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Q35SingleCode extends Model
{
    use SoftDeletes;

    protected $table = 'Q35SingleCode';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function q35PreSingleCode()
    {
        return $this->hasOne('App\Models\Q35PreSingleCode', 'seq', 'seq');
    }
}
