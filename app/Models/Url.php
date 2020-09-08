<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
	protected $fillable = ['original_url', 'tiny_url', 'status'];
	public $timestamps = false;
    protected $table = 'links';
	
	public function log()
    {
		return $this->hasMany('App\Models\UrlLog', 'link_id', 'id');
    }
}
