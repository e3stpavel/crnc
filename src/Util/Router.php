<?php

namespace App\Util;

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
    public static function addRoute(string $uri, string $method, array $callback): void
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
        self::addRoute($uri, 'GET', $callback);
    }

    /**
     * @param string $uri
     * @param array $callback
     */
    public static function post(string $uri, array $callback) : void
    {
        self::addRoute($uri, 'POST', $callback);
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
     */
    public function call(): void
    {
        $match = $this->match();
        $callback = $match['callback'];

        if (isset($callback) && is_callable($callback)) {
            call_user_func($callback);
        } elseif (isset($callback) && is_array($callback)) {
            // call controller method which should return view object
            $controllerClass = $callback[0];
            $controllerMethod = $callback[1];
            $controllerObject = new $controllerClass();
            $controllerObject->$controllerMethod();
        } else {
            // 404 page return in here
            $view = new View('404');
            $view->show();
        }
    }
}
