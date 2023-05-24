<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommandList extends Model
{
    protected $table = 'command_list';
    public $timestamps = true;
    protected $fillable = [
        'organ',
        'comm_num',
        'comm_date',
        'file_name',
        'file_ori_name',
        'file_folder_name',
        'status'
        ];
}
