<?php

namespace App\Util;

use Exception;

class Router
{
    private static array $routes = [];

    private string $uri;

    private string $method;

    /**
     * @param string $uri
     * @param string $method
     */
    public function __construct(string $uri, string $method)
    {
        $this->uri = parse_url($uri)['path'];
        $this->method = $method;
    }

    /**
     * @param string $uri
     * @param string $method
     * @param array $callback
     */
    public static function add(string $uri, string $method, array $callback): void
    {
        self::$routes[] = [
            'uri' => $uri,
            'method' => $method,
            'callback' => $callback,
        ];
    }

    /**
     * @param string $uri
     * @param array $callback
     */
    public static function get(string $uri, array $callback): void
    {
        self::add($uri, 'GET', $callback);
    }

    /**
     * @param string $uri
     * @param array $callback
     */
    public static function post(string $uri, array $callback) : void
    {
        self::add($uri, 'POST', $callback);
    }

    /**
     * @return array
     */
    public function match(): array
    {
        $result = [];

        foreach (self::$routes as $route) {
            if ($route['uri'] === $this->uri && $route['method'] === $this->method) {
                $result = $route;
            }
        }

        return $result;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function call(): void
    {
        $match = $this->match();

        if (isset($match['callback']) && is_callable($match['callback'])) {
            call_user_func($match['callback']);
        } elseif (isset($match['callback']) && is_array($match['callback'])) {
            // call controller method which should return view object
            $callback = $match['callback'];
            $controllerClass = $callback[0];
            $controllerMethod = $callback[1];
            $controllerObject = new $controllerClass();
            $controllerObject->$controllerMethod();
        } else {
            // 404 page return in here
            View::show('404');
        }
    }
}
