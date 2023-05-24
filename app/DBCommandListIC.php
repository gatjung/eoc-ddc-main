<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DBCommandListIC extends Model
{
    protected $table = 'command_list_ic';
    public $timestamps = true;
    protected $fillable = [
        'command_name',
        'file_name',
        'file_ori_name',
        'command_date',
        'user_id_upload',
        'user_id_delete',
        'status'
    ];
}
