<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Q35PreMultiCode extends Model
{
    protected $table = 'Q35PreMultiCode';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'code',
        'url_code',
    ];
}
