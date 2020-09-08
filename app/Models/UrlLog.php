<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UrlLog extends Model
{
    protected $fillable = ['link_id', 'user_key'];
	public $timestamps = false;
    protected $table = 'links_log';
	
	/**
	* "Загружающий" метод модели.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();
		
		static::addGlobalScope('order', function (Builder $builder) {
			
			$builder->orderBy('id');
		});
	}
	
	/**
	* Преобразовать поле date.
	*
	* @param  string  $value
	* @return string
	*/
	public function getDateAttribute($value)
	{
		return date("d.m.Y H:i:s", strtotime($value));
	}
	
	public function img()
	{
		return $this->hasOne('App\Models\UrlLogImg', 'log_id', 'id');
	}
	
	public function link()
	{
		return $this->hasOne('App\Models\Url', 'id', 'link_id');
	}
}
