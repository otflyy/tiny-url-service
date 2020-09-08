<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Url;
use App\Models\UrlImg;
use App\Models\UrlLog;
use App\Models\UrlLogImg;

class TinyUrlController extends Controller
{
	protected $url = '';
	protected $random_string = '';
	
	public function index()
    {
		return view('url');
	}
	
	/* Statistics controller. */
	
	public function getStat(Request $request): array
	{
		if($request->ajax())
		{
			$result = ['error' => '', 'list' => []];
			
			$result['list'] = collect(Url::where('tiny_url', trim(strip_tags((string)$request->input('link'))))->with('log', 'log.img', 'log.img.url')->first())->toArray();
			
			if(empty($result['list']))
				$result['error'] = 'Incorrect short link!';
			
			return $result;
		}
	}
	
	/* Total statistics controller. */
	
	public function getStatTotal(Request $request): array
	{
		if($request->ajax())
		{
			$result = ['stat_total' => [], 'period' => ''];
			
			$log_list = collect(UrlLog::whereBetween('date', [date("Y-m-d", time() - 1209600), date("Y-m-d", strtotime('tomorrow'))])->with('link')->get())->toArray();

			foreach($log_list as $row) {
				$result['stat_total'][$row['link_id']] = [
					'count' => collect($log_list)->where('link_id', $row['link_id'])->unique('brand')->count(),
					'url' => $row['link']['tiny_url']
				];
			}

			$result['period'] = date("d.m.Y", time() - 1209600).' - '.date("d.m.Y", time());
			
			return $result;
		}
	}
	
	/* The controller clicks the short link. */
	
	public function getLink (Request $request): array
	{
		if($request->ajax())
		{
			$result = ['error' => '', 'img' => '', 'url' => '', 'user_hash' => '', 'log' => ''];
			
			$str = Url::where('tiny_url', trim(strip_tags((string)$request->input('link'))))->first();
			
			if(!$str)
				$result['error'] = 'Incorrect short link!';
			elseif(time() - strtotime($str->date) >= (int)$request->input('sec'))
				$result['error'] = 'The short link has expired!';
			else {
				
				$log = UrlLog::create(['link_id' => $str->id]);
				
				if($str->status === 1) {
					$random_img = UrlImg::inRandomOrder()->first();
					
					UrlLogImg::create(['img_id' => $random_img->id, 'log_id' => $log->id]);
					
					$result['img'] = $random_img->url;
				}
				
				$this->get_random_str(new UrlLog, 'user_key');
				
				$result['url'] = $str->original_url;
				$result['user_hash'] = $this->random_string;
				$result['log'] = $log->id;
			}
			
			return $result;
		}
	}
	
	/* Short link creation controller. */
	
	public function setUrl(Request $request)
    {
		if($request->ajax())
		{
			$error = $this->param_validation($request);
			
			if($error)
				return ['error' => $error['error']];
			
			Url::create(['original_url' => $this->url, 'tiny_url' => $this->random_string, 'status' => (int)$request->input('commercial')]);
			
			return true;
		}
	}
	
	/* Updating the user's key in the log. */
	
	public function setUserLog(Request $request): int
    {
		if($request->ajax())
		{
			$log = UrlLog::find((int)$request->input('log'));
			$log->user_key = (string)$request->input('user');
			$log->save();
			
			return 0;
		}
	}
	
	/* Checking input parameters before creating a new short link. */
	
	private function param_validation($request)
	{
		$this->url = trim(strip_tags((string)$request->input('url')));
		
		if($this->url === '')
			return ['error' => 'Invalid URL!'];
		
		if(strpos($this->url, $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']) !== false)
			return ['error' => 'This URL cannot contain the address of the current site!'];
		
		if((string)$request->input('tiny_url') !== '') {
			$this->random_string = trim(strip_tags((string)$request->input('tiny_url')));
			
			if($this->random_string === '')
				return ['error' => 'Incorrect short link!'];
			
			if(Url::where('tiny_url', $this->random_string)->count() > 0)
				return ['error' => 'This link already exists, try another one!'];
		}
		else
			$this->get_random_str(new Url, 'tiny_url');
		
		return null;
	}
	
	/* Random string generator. Generates the user's original key and a short url. */
	
	private function get_random_str($model_object, $field)
	{
		$rand_str = md5(time());
		$min_random_int = random_int(1, 10);
		$max_random_int = random_int($min_random_int + 5, strlen($rand_str));
		
		$rand_str = substr(str_shuffle($rand_str), $min_random_int, $max_random_int);
		
		if($model_object::where($field, $rand_str)->count() > 0)
			$this->get_random_str($model_object, $field);
		else
			$this->random_string = $rand_str;
	}
}
