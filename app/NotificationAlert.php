<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationAlert extends Model {

  protected $table = 'notify_messages';
	protected $fillable = ['sender_name','sender_u_id','receiver_name','receiver_u_id','subject','detail','url_redirect','module_name'];
  public $timestamps = true;

	public function scopeListMessage()
	{
		return $this->get();
	}

	public function scopeCountNewMessage($query,$id)
	{
		//return $this->where('seen',0)->get();
    return $query->where('receiver_u_id',$id)->where('seen',0)->get();
	}
  public function scopeListNewMessage($query,$id)
	{
		//return $this->where('seen',0)->get();
    return $query->where('receiver_u_id',$id)->where('seen',0)->get();
	}

	public function scopeUpdateSeen($query,$id)
	{
		return $query->where('id',$id)->update(['seen'=>1]);
	}

	public function scopeDetailMessage($query,$id)
	{
		return $query->find($id)->toArray();
	}
}
