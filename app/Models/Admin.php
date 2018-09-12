<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
  use SoftDeletes;

  protected $table = 'Admin';

  protected $guarded = [
      'seq',
  ];

  public $primaryKey = 'seq';

  protected $fillable = [
      'id',
      'password',
      'admin_level',
      'name',
      'email',
      'phone_num',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password'
  ];
}
