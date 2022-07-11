<?php

namespace Atabasch\Core\Routing;

use Atabasch\Core\Config;
use Atabasch\Core\Request;
use Atabasch\Core\Response;
use Atabasch\Core\Url;

class RouteRunner{

    private $routes = [];

    public function __construct($routes=[]){
        $this->routes = $routes;
        $route = $this->findRoute();
        if(!$route){
            return self::runFallback();
        }else{
            if($route->redirect){
                return Response::redirect($route->handler);
            }else{
                return self::runRoute($route);
            }
        }
    }

    private function findRoute(){
        $theRouteFound = false;
        $routes = array_merge( ($this->routes[Request::method()] ?? []), ($this->routes['*'] ?? []) );
        if(count($routes)){
            foreach(array_keys($routes) as $routePath){
                if(preg_match('@^'.rtrim($routePath, '/').'$@mu', Request::path(), $variables)){
                    $theRouteFound = $routes[$routePath];
                    array_shift($variables);
                    $theRouteFound->variables = $variables;
                    break;
                }
            }
        }

        return $theRouteFound;
    }

    private function runRoute($route){
        if(is_callable($route->handler)){
            return $this->runHandler($route->handler, $route->variables);
        }elseif(is_string($route->handler)){
            $controllerDatas = $this->getDatasForController(explode('::', $route->handler));
            return $this->runController($controllerDatas,  $route->variables);
        }elseif(is_array($route->handler)){
            $controllerDatas = $this->getDatasForController($route->handler);
            return $this->runController($controllerDatas,  $route->variables);
        }else{

        }


    }

    private function getDatasForController($handlerArray){
        $handlerArray[1] = $handlerArray[1] ?? 'index';

        $namespace = trim(($route->namespace ?? (Config::get('app.namespace.controller') ?? "\\")), '\\');
        $handlerArray[0] = str_replace($namespace, '', $handlerArray[0]);
        $handlerArray[0] = '\\'.$namespace.'\\'.preg_replace("/(^\\\*)/", '', $handlerArray[0]);

        return $handlerArray;
    }

    private function runHandler(\Closure $handler, array $variables = []){
        return call_user_func_array($handler, $variables);
    }

    private function runController($controllerDatas, array $variables=[]){
        $controllerClass = new $controllerDatas[0];
        return call_user_func_array([$controllerClass, $controllerDatas[1]], $variables);
    }

    private  function runFallback(){
        $route = $this->routes['ERROR']['/'] ?? false;
        if(!$route){
            echo "NOT FOUND";
        }else{
            return $this->runRouter($route);
        }
    }


}