<?php
/*@author Agnes Aronsson*/

class Router {
	# each method will  map to array of key/value pairs: url => action  
	protected $routes = [
		'GET' => [],
		'POST' => []
	];
	
	public $patterns = [
		"index" => "#^/$#",
		"message" => '#^/message/#',
	];
	
	# get-method called from index-php. Save defined '/'-path
	public function get($path, $callback) {
		$this->routes['GET'][$path] = $callback;
	}
	
	# post-method called from index-php. Save defined '/message/{id}'-path	
	public function post($path, $callback) {
		$this->routes['POST'][$path] = $callback;
	}	
	
	# callback
	public function request($method, $uri) {
		# get array of call method
		foreach($this->routes[$method] as $path => $callback) {
			
			# return function if call for index
			if(preg_match($this->patterns['index'], $uri)) {
				return call_user_func($callback); 
			}
			
			# return function if call for message
			if(preg_match($this->patterns['message'], $uri, $matches)) {
				$matches['id'] = explode($matches[0], $uri)[1];
				return call_user_func($callback, $matches);
			}
		}
	}	
}
?>
