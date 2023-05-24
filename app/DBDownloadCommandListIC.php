<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DBDownloadCommandListIC extends Model
{
    protected $table = 'download_command_list_ic';
    public $timestamps = true;
    protected $fillable = [
        'users_id',
        'command_list_id'
    ];
}
