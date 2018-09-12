<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminLevelHasAdminAction extends Model
{
    use SoftDeletes;

    protected $table = 'AdminLevelHasAdminAction';

    protected $guarded = [
        'seq',
    ];

    public $primaryKey = 'seq';

    protected $fillable = [
        'admin_level',
        'admin_action',
    ];

    protected $hidden = [

    ];
}
