<?php

namespace AhmetBarut\Multilang;

use AhmetBarut\Multilang\Exceptions\MethodNotFoundException;
use Closure;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route as FacadesRoute;
use ReflectionFunction;
use ReflectionMethod;

/**
 * @author Ahmet Barut - ahmetbarut588@gmail.com
 */

class Route
{
    /**
     * Stores the language
     * @var $locale
     */
    protected static $locale;

    /**
     * Available methods
     */
    protected static array $methods = [
        'get',
        'post',
        'put',
        'patch',
        'delete',
        'options',
        'head',
        'group',
    ];

    /**
     * Store the route
     * @var \Illuminate\Routing\Route $route
     */
    protected static $route;

    /**
     * @param $locale
     * @return void
     */
    public function __construct($locale = null)
    {
        static::$locale = $locale;
    }

    /**
     * Captures routes using Annotation
     * @param Closure|array $callback
     * @return mixed|void
     */
    public static function findAnottations(Closure|array $callback, $method, $routeName = null)
    {
        if (is_callable($callback)) {
            $reflection = new ReflectionFunction($callback);
        }

        if (is_array($callback)) {
            $reflection = new ReflectionMethod($callback[0], $callback[1]);
        }

        preg_match('/\@Route\((.*)\)/', $reflection->getDocComment(), $matches);

        $matched = static::stringToArray($matches[1]);
        if (count($matched) === 0) {
            $route = explode(',', str_replace(['\'', "\"", " "], '', $matches[1]));
            $matched[$route[0]] = $route[1];
        }

        foreach ($matched as $locale => $path) {
            if (!is_numeric($locale) && static::$locale == $locale) {
                // static::$annotations[$key] = $locale;
                static::setRoute($method, $path, $callback);
            }
        }

        return static::$route;
        // throw new AnnotationNotMatchedException("Annotation not matched");
    }

    /**
     * Converts string values defined in Annotation to array
     * @param $string
     * @return array
     */
    public static function stringToArray(string $string): array
    {
        $matched = [];
        $array = explode(',', str_replace(['[', ' ', "]"], '', $string));

        foreach ($array as $value) {
            preg_match('/(.*)=>(.*)/', $value, $matches);
            if ($matches) {
                $matched[$matches[1]] = $matches[2];
            }
        }

        return $matched;
    }

    public static function __callStatic($name, $arguments)
    {
        if (!in_array($name, static::$methods)) {
            throw new MethodNotFoundException("Method {$name} not found");
        }
        app(static::class);

        $routeName = null;

        if (isset($arguments[2])) {
            $routeName = $arguments[2];
        }

        if (is_callable($arguments[0])) {
            return static::findAnottations($arguments[0], $name, $routeName);
        }

        if (is_array($arguments[0]) && !isset($arguments[1])) {
            return static::findAnottations($arguments[0], $name, $routeName);
        }

        $routes = collect($arguments[0]);
        $action = $arguments[1];

        $locale = static::$locale;

        $routes->map(function ($route, $routeLocale) use ($name, $action, $locale, $routeName) {
            if ($locale == $routeLocale) {
                static::setRoute($name, $route, $action);
            }
        });

        return static::$route;
    }

    protected static function setRoute($method, $path, $action)
    {
        static::$route = FacadesRoute::$method($path, $action);
    }

    public static function group($attributes, Closure $callback)
    {
        return app(Router::class)->group($attributes, $callback);
    }
}
