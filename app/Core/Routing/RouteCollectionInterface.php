<?php

namespace Atabasch\Core\Routing;

interface RouteCollectionInterface{

    const PLACEHOLDERS = [
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

    public function create(array $methods, string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function get(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function post(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function put(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function patch(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function delete(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function head(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function options(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function match(array $methods, string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function any(string $path, array|string|\Closure $handler, array $options): RouteCollection;

    public function redirect(string $path, string $to): RouteCollection;

    public function error(array|string|\Closure $handler): RouteCollection;

    public function group(string $prefix, array $options=[], \Closure $closure=null): RouteCollection;

}