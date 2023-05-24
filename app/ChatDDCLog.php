<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatDDCLog extends Model

{
    protected $table = 'chatall_log';
    public $timestamps = true;
    protected $fillable = [
          'username',
          'message',
          'ip',
          'created_at',
          ];

}
