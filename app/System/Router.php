<?php

namespace Atabasch\System;

class Router{


    private ?string $name = null;
    private ?string $domain = null;
    private ?string $prefix = null;
    private array $middlewares = [];
    private array $routes = [];
    private array $namedRoutes = [];
    private bool $isGroup = false;
    private ?array $allMethods = ["GET", "POST", "PUT", "PATCH", "DELETE", "HEAD", "OPTIONS"];

    private array $regexListForPath = [
        '/\{([a-zA-Z_]+):single\}/i'    =>  '?(\d)',
        '/\{([a-zA-Z_]+):bool\}/i'      =>  '?(0|1)',
        '/\{([a-zA-Z_]+):boolean\}/i'   =>  '?(0|1)',
        '/\{([a-zA-Z_]+):id\}/i'        =>  '?(-?\d+)',
        '/\{([a-zA-Z_]+):int\}/i'       =>  '?(-?\d+)',
        '/\{([a-zA-Z_]+):number\}/i'    =>  '?(-?[0-9\.]+)',
        '/\{([a-zA-Z_]+):float\}/i'     =>  '?(-?[0-9\.]+)',
        '/\{([a-zA-Z_]+):double\}/i'    =>  '?(-?[0-9\.]+)',
        '/\{([a-zA-Z_]+):slug\}/i'      =>  '?([A-Za-z0-9-_]+)',
        '/\{([a-zA-Z_]+):string\}/i'    =>  '?([A-Za-z0-9-_]+)',
        '/\{([a-zA-Z_]+)\}/i'          =>  '?([A-Za-z0-9-_]+)',
        '/\{([a-zA-Z_]+):alphabet\}/i'  =>  '?([A-Za-z-_]+)',
        '/\{([a-zA-Z_]+):abc\}/i'       =>  '?([A-Za-z-_]+)',
    ];

    // Pathi regexli hale getirir.
    private function pathToRegex(string $path=null): string{
        return preg_replace(array_keys($this->regexListForPath), array_values($this->regexListForPath), $path);
    }

    // Pathdeki değişken isimlerini alır.
    private function getVariableNames($path){
        $path = preg_replace('@\:[a-zA-Z-_]+\}@imu', '}', $path);
        preg_match_all('@\{([a-zA-Z-_]+)\}@imu', $path, $variables);
        array_shift($variables);
        return count($variables[0])? $variables[0] : null;
    }

    public function getRoutes(){
        return $this->routes;
    }

    /**
     * Router roluşturan method
     *
     * @param array $methods
     * @param string $path
     * @param mixed $handler
     * @param array $options
     * @return void
     */
    public function create(array $methods, string $path, mixed $handler, array $options=[]){
        $path = !$this->prefix? '/'.trim($path, '/') : $this->prefix.'/'.trim($path, '/');

        $name = $options['name'] ?? null;
        $name = $this->name.$name;
        $name = empty($name)? $path : $name;

        foreach ($methods as $method){
            $route = (object) [
                'name'          => $name,
                'method'        => $method,
                'path'          => $path,
                'pathRegex'     => $this->pathToRegex($path),
                'handler'       => $handler,
                'variables'     => $this->getVariableNames($path),
                'middlewares'   => count($this->middlewares)? $this->middlewares : null,
            ];
            $this->routes[$method][$path] = $route;
        }
        if($name){
            $this->namedRoutes[$name] = $path;
        }

        if(!$this->isGroup){
            $this->done();
        }
    }

    /**
     * Aşağıdaki methodların hepsi oluşturulacak routerlar için method belirler.
     *
     * @param string $path
     * @param mixed $handler
     * @param array $options
     * @return $this
     */
    public function get(string $path, mixed $handler, array $options=[]): Router{
        $this->create(['GET'], $path, $handler, $options);
        return $this;
    }
    public function post(string $path, mixed $handler, array $options=[]): Router{
        $this->create(['POST'], $path, $handler, $options);
        return $this;
    }
    public function put(string $path, mixed $handler, array $options=[]): Router{
        $this->create(['PUT'], $path, $handler, $options);
        return $this;
    }
    public function patch(string $path, mixed $handler, array $options=[]): Router{
        $this->create(['PATCH'], $path, $handler, $options);
        return $this;
    }
    public function delete(string $path, mixed $handler, array $options=[]): Router{
        $this->create(['DELETE'], $path, $handler, $options);
        return $this;
    }
    public function head(string $path, mixed $handler, array $options=[]): Router{
        $this->create(['HEAD'], $path, $handler, $options);
        return $this;
    }
    public function options(string $path, mixed $handler, array $options=[]): Router{
        $this->create(['OPTIONS'], $path, $handler, $options);
        return $this;
    }
    public function match(array $methods, string $path, mixed $handler, array $options=[]){
        $this->create($methods, $path, $handler, $options);
        return $this;
    }
    public function any(string $path, mixed $handler, array $options=[]){
        $this->create(['*'], $path, $handler, $options);
        return $this;
    }

    /**
     * Routerları gruplayan methoddur. Bu fonksiyonun içindeki her router grubun özelliklerini alır.
     *
     * @param $callback
     * @return $this
     */
    public function group($callback=null){
        $this->isGroup=true;
        if(is_callable($callback)){
            $callback($this);
        }
        $this->done();
        $this->isGroup=false;
        return $this;
    }


    /**
     * Prefix Belirlemek
     *
     * @param string $prefix
     * @return $this
     */
    public function prefix(string $prefix){
        $this->prefix = $this->prefix.'/'.trim($prefix, '/');
        return $this;
    }
    public function clearPrefix(){
        $this->prefix = null;
        return $this;
    }

    /**
     * Middleware belirlemek
     *
     * @param array $middlewares
     * @return $this
     */
    public function middleware(array $middlewares=[]){
        $this->middlewares = array_unique( array_merge($this->middlewares, $middlewares) );
        return $this;
    }
    public function clearMiddleware(){
        $this->middlewares = [];
        return $this;
    }

    /**
     * Domain Belirlemek
     *
     * @param array $domain
     * @return $this
     */
    public function domain(array $domain=[]){
        $this->domain = $domain;
        return $this;
    }
    public function clearDomain(){
        $this->domain = null;
        return $this;
    }

    /**
     * Router ismi verlirlemel
     *
     * @param string|null $name
     * @return $this
     */
    public function name(string $name = null){
        $this->name = $this->name.$name;
        return $this;
    }
    public function clearName(){
        $this->name = null;
        return $this;
    }


    /**
     * Özel atamaları temizlemek
     *
     * @return $this
     */
    public function done(){
        $this->clearPrefix();
        $this->clearMiddleware();
        $this->clearDomain();
        $this->clearName();
        return $this;
    }


    /**
     * Hata Sayfalarında çalışacak router belirlenir.
     *
     * @param $handler
     * @return void
     */
    public function setError(mixed $handler=null): Router{
        $this->routes['ERROR'] = (object) [
            'handler' => $handler
        ];
        return $this;
    }



    public function run(){
        new \Atabasch\System\RouteRunner($this->getRoutes());
    }



}