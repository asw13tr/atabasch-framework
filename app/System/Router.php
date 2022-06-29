<?php

namespace Atabasch\System;


class Router{

    private string $controllerNamespace = 'Atabasch\Controllers';

    private ?array $errorRoute = null;

    private string $lastPath = '';

    private array $routes = [];

    private array $namedRoutes = [];

    private mixed $routeError = null;

    private array $pathRegex = [
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

    /**
     * Router çalıştırma methodu
     *
     * @return void
     */
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
                $isRoute = preg_match('@^'.$route->pathRegex.'$@miu', $request->path(), $variables);
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
        if(!$this->routeError){
            echo 'Not Found';
        }else{
            $this->runRoute($this->routeError);
        }
    }



    public function setError($handler=null){
        $this->routeError = (object) [
            'handler' => $handler
        ];
    }

    //-------------------------------------------------------------------------------------
    public function pathToRegex(string $path=null): string{
        return preg_replace(array_keys($this->pathRegex), array_values($this->pathRegex), $path);
    }


    //-------------------------------------------------------------------------------------
    public function add(array $methods=["GET"], string $path='', mixed $handler=null): void{
        $this->lastPath = $path;
        foreach($methods as $method){
            $this->routes[strtoupper($method)][$path] = (object)[
                'handler'   => $handler,
                'path'      => $path,
                'pathRegex' => $this->pathToRegex($path)
            ];
        }
    }

    public function get(string $path, mixed $handler = null): Router{
        $this->add(["GET"], $path, $handler);
        return $this;
    }

    public function post(string $path, mixed $handler = null): Router{
        $this->add(["POST"], $path, $handler);
        return $this;
    }

    public function put(string $path, mixed $handler = null): Router{
        $this->add(["PUT"], $path, $handler);
        return $this;
    }

    public function patch(string $path, mixed $handler = null): Router{
        $this->add(["PATCH"], $path, $handler);
        return $this;
    }

    public function delete(string $path, mixed $handler = null): Router{
        $this->add(["DELETE"], $path, $handler);
        return $this;
    }

    public function head(string $path, mixed $handler = null): Router{
        $this->add(["HEAD"], $path, $handler);
        return $this;
    }

    public function options(string $path, mixed $handler = null): Router{
        $this->add(["OPTIONS"], $path, $handler);
        return $this;
    }

    public function any(string $path, mixed $handler = null): Router{
        $this->add(["GET", "POST", "PUT", "PATCH", "DELETE", "HEAD", "OPTIONS"], $path, $handler);
        return $this;
    }

    public function name(string $name=null){
        if($name){
            $this->namedRoutes[$name] = $this->lastPath;
        }
    }


}