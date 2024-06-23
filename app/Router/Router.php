<?php

namespace App\Router;

use BadMethodCallException;
use Exception;

class Router
{
    private array $routes = [];

    private string $requestUri;

    public function __construct()
    {
        $routes = require_once __DIR__ . '/routes.php';

        foreach ($routes as $routePath => $route) {
            if (!in_array($routePath, $this->routes)) {
                $this->routes[$routePath] = $route;
            }
        }

        $this->setRequestUri();
    }

    /**
     * @throws Exception
     */
    public function run(): mixed
    {
        $url = $this->getUrl();

        if ($this->isValidRoute($url)) {
            $route = $this->getRoute($url);
            $arguments = $this->getRouteArguments();

            return $this->callController($route, $arguments);
        }

        return null;
    }

    private function setRequestUri(): void
    {
        if (php_sapi_name() == 'cli') {
            $this->requestUri = '/' . $_SERVER['argv'][1];
        }

        if (in_array(php_sapi_name(), ['fpm-fcgi'])) {
            $this->requestUri = $_SERVER['REQUEST_URI'];
        }
    }

    private function isValidRoute(string $requestPath): true
    {
        if (!isset($this->routes[$requestPath])) {
            throw new Exception("No such route path '{$requestPath}'");
        }

        return true;
    }

    private function getUrl(): string
    {
        return parse_url($this->requestUri, PHP_URL_PATH);
    }

    private function getRoute(string $requestPath): array
    {
        return $this->routes[$requestPath];
    }

    private function getRouteArguments(): array
    {
        $arguments = parse_url($this->requestUri, PHP_URL_QUERY);

        if (empty($arguments)) {
            return [];
        }

        return array_map(function ($argument) {
            $argument = explode('=', $argument);
            return ['key' => $argument[0], 'value' => $argument[1]];
        }, explode('&', $arguments));
    }

    private function callController(array $route, array $arguments): mixed
    {
        if (!class_exists($route['controller'])) {
            throw new Exception("Controller class '{$route['controller']}' does not exist");
        }

        if (!method_exists($route['controller'], $route['name'])) {
            throw new Exception("Method '{$route['name']}' does not exist");
        }

        $argumentKeys = (array_column($arguments, 'key'));
        if (count($argumentKeys) !== count($route['arguments'])) {
            throw new Exception("Number of arguments keys does not match");
        }

        $argumentKeys = (array_column($arguments, 'key'));
        if (array_diff($argumentKeys, $route['arguments'])) {
            throw new Exception("Wrong route arguments");
        }

        return call_user_func_array([new $route['controller'], $route['name']], array_column($arguments, 'value'));
    }
}