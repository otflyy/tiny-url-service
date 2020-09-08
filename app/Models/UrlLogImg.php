<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlLogImg extends Model
{
    protected $fillable = ['img_id', 'log_id'];
	public $timestamps = false;
    protected $table = 'links_log_img';
	
	public function url()
	{
		return $this->hasOne('App\Models\UrlImg', 'id', 'img_id');
	}
}
