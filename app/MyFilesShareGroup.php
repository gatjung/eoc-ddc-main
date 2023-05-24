<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFilesShareGroup extends Model
{
  protected $table = 'ddcdrive_sharing_group';
  public $timestamps = true;
  protected $fillable = [
        'file_id',
        'role_or_group',
        'owner_user_id',
        'file_status'
        ];
}
