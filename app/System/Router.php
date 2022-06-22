<?php

namespace Atabasch\System;
use Atabasch\System\Url;

class Router{

    private $url = null;

    private $routes = [];


    private $pathRegex = [
        '{id}'        =>  '([0-9]+)',
        '{int}'       =>  '([0-9]+)',
        '{number}'    =>  '([0-9]+)',
        '{slug}'      =>  '([A-Za-z0-9-_]+)',
        '{string}'    =>  '([A-Za-z0-9-_]+)',
        '{alphabet}'  =>  '([A-Za-z-_]+)',
        '{abc}'       =>  '([A-Za-z-_]+)'
    ];

    public function __construct(){
        $this->url = new Url();
    }


    public function run(){
        foreach($this->routes as $key => $route){
            $currentUri = $_SERVER["REQUEST_METHOD"].'__'.$this->url->requestUri();
            $findRoute = preg_match($key, $currentUri, $vars);
            unset($vars[0]);

            if($findRoute){

                if(is_callable($route->handler)){
                    call_user_func_array($route->handler, $vars);
                }
                break;
            }
        }
    }


    public function get(string $path, $callback=null){
        $this->addRoute("GET", $path, $callback);
    }



    public function addRoute(string $method, string $path, $handler){
        $regexPath = str_replace( array_keys($this->pathRegex), array_values($this->pathRegex), $path );
        $regexPath = str_replace(['/'], ['\/'], $regexPath);

        $this->routes["/^{$method}__{$regexPath}$/ium"] = (object)[
            'method'    => $method,
            'path'      => $path,
            'handler'   => $handler
        ];
    }

    public function checkPath($path){
        $result = $path==$this->url->requestUri();
        return $result;
    }

    public function checkMethod($methods = "GET"){
        $methodsArray = explode(',', str_replace(['|','-','/'], ',', strtoupper($methods)));
        return in_array($_SERVER["REQUEST_METHOD"], $methodsArray);
    }




}