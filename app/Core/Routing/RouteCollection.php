<?php

namespace Atabasch\Core\Routing;

use Atabasch\Core\Config;
use Atabasch\Core\Request;
use stdClass;

class RouteCollection implements RouteCollectionInterface{

    private static array $routes = [];

    private static array $namedRoutes = [];

    private static Route|null $currentRoute = null;

    private static array $options = [
        'isGroup'       => false,
        'prefix'        => null,
        'as'            => null,
        'middleware'    => [],
        'domain'        => null,
        'namespace'     => null
    ];


    // Sınıfı döndürür.
    public function getSelf(): RouteCollection{
        return new self();
    }



    /**
     * Yeni bir route oluşturur.
     *
     * @param array $methods
     * @param string $path
     * @param string $handler
     * @return RouteCollection
     */
    public function create(array $methods, string $path, mixed $handler, array $options=[]): RouteCollection
    {
        $options['prefix'] = (self::$options['prefix'] ?? null) . ($options['prefix'] ?? null);

        $options['middleware'] = array_merge((self::$options['middleware'] ?? []), ($options['middleware'] ?? []));
        $options['middleware'] =  array_unique($options['middleware']);

        $options['namespace'] =  ($options['namespace'] ?? (self::$options['namespace'] ?? null) );

        $options['domain'] =  ($options['domain'] ?? (self::$options['domain'] ?? null) );

        if(isset($options['as'])){
            $options['as'] = (self::$options['as'] ?? null) . ($options['as'] ?? null);
        }

        self::$currentRoute = new Route($methods, $path, $handler, $options);
        foreach($methods as $method){
            self::$routes[$method][self::$currentRoute->regexPath] = self::$currentRoute;
        }

        $name = self::$currentRoute->as;
        if($name){
            self::$namedRoutes[$name] = $path;
        }

        return self::getSelf();
    }


    //======================================================================================================
    public function get(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['GET'], $path, $handler, $options);
    }
    public function post(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['POST'], $path, $handler, $options);
    }
    public function put(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['PUT'], $path, $handler, $options);
    }
    public function patch(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['PATCH'], $path, $handler, $options);
    }
    public function delete(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['DELETE'], $path, $handler, $options);
    }
    public function head(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['HEAD'], $path, $handler, $options);
    }
    public function options(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['OPTIONS'], $path, $handler, $options);
    }
    public function match(array $methods, string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        $methods = array_map(function ($method){
            return strtoupper($method);
        }, $methods);
        return self::create($methods, $path, $handler, $options);
    }
    public function any(string $path, array|string|\Closure $handler, array $options=[]): RouteCollection{
        return self::create(['*'], $path, $handler, $options);
    }
    public function redirect(string $path, string $to): RouteCollection{
        return self::create(['*'], $path, $to, ['redirect'=>true]);
    }
    public function error(array|\Closure|string $handler): RouteCollection{
        return self::create(['ERROR'], '/', $handler);
    }


    public function group(string $prefix, array $options=[], \Closure $closure=null): RouteCollection{
        self::updateGroupOptions($prefix, $options);

        if(is_callable($closure)){
            $closure($this);
        }
        self::resetOptions();
        return self::getSelf();
    }


    public function updateGroupOptions($prefix, $options){
        self::$options = [
            'isGroup'       => true,
            'prefix'        => (self::$options['prefix'] ?? null) . ($prefix ?? null),
            'as'            => (self::$options['as'] ?? null) . ($options['as'] ?? null),
            'middleware'    => ($options['middleware'] ?? []),
            'domain'        => ($options['domain'] ?? null),
            'namespace'     => ($options['namespace'] ?? null)
        ];
    }

    public function resetOptions(){
        self::$options = [
            'isGroup'       => false,
            'prefix'        => null,
            'as'            => null,
            'middleware'    => [],
            'domain'        => null,
            'namespace'     => null
        ];
    }

    public function getRoutes(string $method=null, bool $justIndex = false): array{
        $result =  !$method? self::$routes : self::$routes[strtoupper($method)];
        return !$justIndex? $result : array_keys($result);
    }

    public function getNamedRoutes(): array{
        return self::$namedRoutes;
    }

    public function run(){
        new RouteRunner(self::$routes);
    }



}