<?php

namespace Atabasch\System;

class Ram{

    private static $instance = null;

    private static $routes = [];

    //Sınıfımızın construct (kurucu) metotu private yada protected tanımlıyoruz.
    private function __construct(){

    }

    // Dışarıdan sınıfımızı çağıracağımız metodumuz.
    public static function getInstance()
    {
        // eğer daha önce örnek oluşturulmamış ise sınıfın tek örneğini oluştur
        if (static::$instance == null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    // dışarıdan kopyalanmasını engelledik
    private function __clone()
    {
    }

    // unserialize() metodu ile tekrardan oluşturulmasını engelledik
    private function __wakeup()
    {
    }

    public static function setRoutes($routes){
        static::$routes = $routes;
    }

    public static function getRoutes(){
        return static::$routes;
    }
}