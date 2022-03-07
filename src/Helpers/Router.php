<?php

class Router
{
	private static array $routes = [];
	private mixed $uri;
	private mixed $method;

	/**
	 * @param $uri
	 * @param $method
	 */
	public function __construct($uri, $method)
	{
		$this->uri = parse_url($uri)['path'];
		$this->method = $method;
	}

	/**
	 * @param $uri
	 * @param $method
	 * @param $callback
	 */
	public static function addRoute($uri, $method, $callback): void
	{
		self::$routes[] = [
			'uri' => $uri,
			'method' => $method,
			'action' => $callback
		];
	}

	/**
	 * @param $uri
	 * @param $callback
	 */
	public static function get($uri, $callback): void
	{
		self::addRoute($uri, 'GET', $callback);
	}

	/**
	 * @param $uri
	 * @param $callback
	 */
	public static function post($uri, $callback): void
	{
		self::addRoute($uri, 'POST', $callback);
	}

	/**
	 * @return array could be null
	 */
	public function match(): array
	{
		$match = [];
		foreach(self::$routes as $route){
			if($route['uri'] === $this->uri && $route['method'] === $this->method){
				array_push($match, $route);
			}
		}

		return $match;
	}
}