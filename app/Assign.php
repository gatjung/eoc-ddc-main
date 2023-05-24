<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model

{
    protected $table = 'task_order';
    
    public $timestamps = false;


  //   public function roles() {
  //
  //   return $this->belongsToMany('App\Roles','task_order_x_roles','order_id','roles_id');
  // }

}
