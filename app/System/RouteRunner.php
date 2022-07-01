<?php

namespace Atabasch\System;

class RouteRunner{

    private string $controllerNamespace = 'Atabasch\Controllers';

    private array $routes = [];

    public function __construct(array $routes){
        $this->routes = $routes;
        $this->run();
    }


    public function run(): void{
        $router = $this->findRoute();
        if(!$router){
            $this->runError();
        }else{
            $this->runRoute($router);
        }
    }

    /**
     * Parametre olarak gönderile route objesini çalıştırıp parametreleri yollar.
     *
     * @param object $router
     * @return void
     */
    private function runRoute(object $router): void{
        if(is_callable($router->handler)){
            call_user_func_array($router->handler, $router->variables ?? []);
        }else{
            $controller = $this->getControllerInfo($router);
            call_user_func_array( [new $controller->name, $controller->method], $router->variables ?? [] );
        }
    }


    /**
     * Geçerli olan sayfanın method ve path'ine göre belirlenmiş route u bulup döndürür.
     *
     * @return object|null
     */
    private function findRoute(): object|null{
        $request = new Request();
        $resultRouter = null;

        if(isset($this->routes[$request->method()])) {
            foreach($this->routes[$request->method()] as $path => $route){
                $isRoute = preg_match('@^'.rtrim($route->pathRegex, '/').'$@miu', $request->path(), $variables);
                if($isRoute){
                    array_shift($variables);
                    $resultRouter = $route;
                    $resultRouter->variables = $variables;
                    break;
                }
            }
        }

        return $resultRouter;
    }


    /**
     * Parametre olarak göndeerilen Route objesinden, atanmış controller adını ve çalıştırılacak methodu çeker.
     *
     * @param object $router
     * @return object
     */
    private function getControllerInfo(object $router): object{
        if(is_string($router->handler)){
            $router->handler = explode('::', $router->handler);
            if(count($router->handler)<2){
                $router->handler[1] = 'index';
            }
        }

        return (object) [
            'name'   => "\\{$this->controllerNamespace}\\" . trim( str_replace("{$this->controllerNamespace}", '', $router->handler[0]), '\\' ),
            'method' => $router->handler[1]
        ];
    }

    /**
     * 404 Sayfaları için çalışacak olan router
     *
     * @return void
     */
    public function runError(){
        if(!$this->routes['ERROR']){
            echo 'Not Found';
        }else{
            $this->runRoute($this->routes['ERROR']);
        }
    }



}