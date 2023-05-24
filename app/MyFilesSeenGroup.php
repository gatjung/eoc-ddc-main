<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFilesSeenGroup extends Model
{
  protected $table = 'ddcdrive_seen_group';
  public $timestamps = false;
  protected $fillable = [
        'file_id',
        'user_id_sharing',
        'read_at',
        'read_status'
        ];
}
