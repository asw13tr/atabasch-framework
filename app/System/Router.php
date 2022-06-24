<?php

namespace Atabasch\System;
use Atabasch\System\Url;

class Router{

    /** Bu değişkene yapıcı method içerisinde Url sınıfı atanır.
     *
     * @var \Atabasch\System\Url
     */
    private $url = null;

    /**
     * Bu değişken set edilen route nesnesini alır.
     *
     * @var null
     */
    private $current = null;

    /**
     * Geliştirici tarafından oluşturulan routerlar bu dizide saklanır.
     *
     * @var array
     */
    private $routes = [];

    /**
     * "named" methodu ile isim atanan route yolları bu dizi içinde saklanır.
     *
     * @var array
     */
    private $namedRoutes = [];

    /**
     * Sayfa bulunamadığında çalışıcak olan 404 sayfası;
     *
     * @var null
     */
    private $route404 = null;

    /**
     * Oluşturulan routelar için belirlenen koşullu parametrelere denk gelen düzenli ifadeler.
     *
     * @var string[]
     */
    private $pathRegex = [
        '{single}'      =>  '?(\d)',
        '{bool}'      =>  '?(0|1)',
        '{boolean}'   =>  '?(0|1)',
        '{id}'        =>  '?(-?\d+)',
        '{int}'       =>  '?(-?\d+)',
        '{number}'    =>  '?(-?[0-9\.]+)',
        '{float}'     =>  '?(-?[0-9\.]+)',
        '{double}'    =>  '?(-?[0-9\.]+)',
        '{slug}'      =>  '?([A-Za-z0-9-_]+)',
        '{string}'    =>  '?([A-Za-z0-9-_]+)',
        '{}'          =>  '?([A-Za-z0-9-_]+)',
        '{alphabet}'  =>  '?([A-Za-z-_]+)',
        '{abc}'       =>  '?([A-Za-z-_]+)',
    ];





    public function __construct(){
        $this->url = new Url();
    }

    /**
     * Oluşturulan yönlendiricileri çalıştıran method.
     *
     * @return bool|void
     */
    public function run(){
        $route = $this->getRoute();
        if($route){
            return $this->runRoute($route);
        }else{
            return $this->run404();
        }

    }

    /**
     * Çalışan sayfanın url içeriğini oluşturulan yönlendiriciler içerisinde arar.
     * Eğer uyuşan bir yönlendirici bulursa yönlendirici nesnesini döndürür
     * Eğer uyuşan bir yönlendirici bulamazsa false değeri döndürür.
     *
     * @return false|mixed
     */
    public function getRoute(){
        $result = false;
        foreach($this->routes as $key => $route){
            $currentUri = $_SERVER["REQUEST_METHOD"].'__'.$this->url->requestUri();
            $findRoute = preg_match($key, $currentUri, $vars);
            unset($vars[0]);

            if($findRoute){
                $route->variables = $vars;
                $result = $route;
                break;
            }
        }
        return $result;
    }

    /**
     * Parametre olarak gönderilen route nesnesine atanmış olan fonksiyonu çalıştırır.
     *
     * @param $route
     * @return bool|void
     */
    public function runRoute($route){
        if(is_callable($route->handler)){
            call_user_func_array($route->handler, $route->variables);
            return true;
        }

        if(is_array($route->handler)){
            $ctrlClassName = $route->handler[0];
            $ctrlMethodName = $route->handler[1];
        }else{
            list($ctrlClassName, $ctrlMethodName) = explode('::', $route->handler);
        }

        $ctrlClassString = "Atabasch\\Controllers\\".$ctrlClassName;
        $controllerClass = new $ctrlClassString;
        call_user_func_array(array($controllerClass, $ctrlMethodName), $route->variables);
    }

    /**
     * Parametre ile gönderilen fonksiyonu bulunamayan routerlar için çalıştırır.
     *
     * @param $handler
     * @return void
     */
    public function set404($handler=null){
        $this->route404 = $handler;
    }

    /**
     * Hata sayfasını çalıştıran method.
     *
     * @return void
     */
    public function run404(){
        if(!$this->route404){
            echo "Sayfa bulunamadı";
        }else{
            $route = (object)[ 'handler' => $this->route404, 'variables' => [] ];
            $this->runRoute($route);
        }
    }


    /**
     * GET isteiği için bir route oluşturur.
     *
     * @param string $path
     * @param $handler
     * @return $this
     */
    public function get(string $path, $handler=null){
        $this->addRoute("GET", $path, $handler);
        return $this;
    }

    /**
     * POST isteiği için bir route oluşturur.
     *
     * @param string $path
     * @param $handler
     * @return $this
     */
    public function post(string $path, $handler=null){
        $this->addRoute("POST", $path, $handler);
        return $this;
    }


    /**
     * Oluşturulan route nesnesi için bir isim atar.
     *
     * @param string $name
     * @return $this
     */
    public function name(string $name){
        $this->namedRoutes[$name] = $this->current->path;
        return $this;
    }


    /**
     * Girilen url yolundaki {int}, {string}, {abc} gibi dinamik değerleri regex'e çevirir.
     *
     * @param string $path
     * @return array|string|string[]
     */
    public function pathToRegex(string $path){
        $regexPath = str_replace( array_keys($this->pathRegex), array_values($this->pathRegex), $path );
        return str_replace(['/'], ['\/'], $regexPath);
    }

    /**
     * Routes dizisine route nesnesi oluşturur ve ekler.
     *
     * @param string $method
     * @param string $path
     * @param $handler
     * @return $this
     */
    public function addRoute(string $method, string $path, $handler){
        $regexPath = $this->pathToRegex($path);
        $this->current = (object)[
            'method'    => $method,
            'path'      => $path,
            'handler'   => $handler
        ];
        $this->routes["/^{$method}__{$regexPath}$/ium"] = $this->current;
        return $this;
    }

    /**
     * Çalışan sayfanın istek metodu ile parametrede gönderilen metod isimleri uyuşuyor mu?
     *
     * @param $methods
     * @return bool
     */
    public function checkMethod($methods = "GET"){
        $methodsArray = explode(',', str_replace(['|','-','/'], ',', strtoupper($methods)));
        return in_array($_SERVER["REQUEST_METHOD"], $methodsArray);
    }




}