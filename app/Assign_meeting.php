<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assign_meeting extends Model

{
    protected $table = 'task_assign';

    public $timestamps = true;

    protected $fillable = [ 'user_id' ];

}
