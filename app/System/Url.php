<?php

namespace Atabasch\System;

use Atabasch\System\Config;

/*
 * Framework url işlemlerinin yapıldığı sınıf
 * */

class Url{

    private $current = null;
    private $root = null;




    /*
     * Aktif sayfanın tam url adresi ve sitenin ana domaini alınıyor.
     * */
    public function __construct(){
        $this->current = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $config = new Config();
        $this->root = $config->get('app.url');
    }




    /*
     * Ana domain üzerenie ekleme yaparak link oluşturur.
     * */
    public function get($more = ''){
        return trim($this->root, '/').'/'.trim($more, '/');
    }




    /*
     * Aktif sayfanın tam url adresini döndürür
     * */
    public function current(){
        return $this->current;
    }



    /*
     * Uygulamanın kök url adresini verir.
     * */
    public function root(){
        return $this->root;
    }




    /*
     * Uygulama domaininden sonra geri kalan url parçasını verir.
     * */
    public function requestUri($keepQuery=false){
        $result = str_replace($this->root(), '', $this->current());
        return $keepQuery? $result : explode('?', $result)[0];
    }




    /*
     * ? işaretinden sonra girilen get formatındaki query string'i verir
     * */
    public function queryString(){
        return  $_SERVER['QUERY_STRING'];
    }



    /*
     * Request uri parçalarını verir (queryString Hariç)
     * */
    public function requestUriParts(){
        $clearRequestUri = str_replace("?{$this->queryString()}", '', $this->requestUri());
        $clearRequestUri = trim($clearRequestUri, '/');
        return explode('/', $clearRequestUri);
    }



}