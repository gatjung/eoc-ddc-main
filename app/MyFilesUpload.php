<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFilesUpload extends Model
{
  protected $table = 'ddcdrive_myfile';
  public $timestamps = true;
  protected $fillable = [
        'file_name',
        'file_ori_name',
        'files_description',
        'file_folder_name',
        'file_owner',
        'file_status'
        ];
}
