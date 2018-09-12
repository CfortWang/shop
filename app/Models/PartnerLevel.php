<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerLevel extends Model
{
    protected $table = 'PartnerLevel';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        
    ];
}
