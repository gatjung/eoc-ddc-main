<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFilesPrivate extends Model
{
  protected $table = 'ddcdrive_sharing_specific_user';
  public $timestamps = true;
  protected $fillable = [
        'file_id',
        'user_id_sharing',
        'owner_user_id'
        ];
}
