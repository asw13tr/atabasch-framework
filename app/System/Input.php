<?php

namespace Atabasch\System;

class Input{

    /**
     * Post'dan gelen verilerin atanacağı sınıf değişkeni
     *
     * @var array
     */
    private $postDatas = [];

    /**
     * Yapıcı method post ile gelen verileri postDatas değişkenine atar.
     *
     */
    function __construct(){
        $this->postDatas = (count($_POST)>0)? json_encode($_POST) : file_get_contents("php://input");
    }

    /**
     * QueryString verilerini alır.
     *
     * @param $key
     * @param $default
     * @return string
     */
    public function get($key=null, $default=null): mixed{
        if(!$key){
            return $_GET;
        }else{
            return $_GET[$key] ?? $default;
        }
    }

    /**
     * Post'dan gelen değerleri alır.
     *
     * @param string|null $index
     * @param $default
     * @return false|mixed|string
     */
    public function post(string $index=null, $default=null): mixed
    {
        if(!$index){
            return $this->postDatas;
        }elseif(preg_match('@->|\.|-|,@', $index)){
            return $this->getPostDataFromArray($this->getIndexParts($index), $default);
        }else{
            return $this->postDatas[$index];
        }
    }

    /**
     * Posttan gelen verileri almak için key.key2.key3 mantığı ile girilen değerleri parçalayıp bir dizi yapar.
     *
     * @param string $key
     * @return array
     */
    private function getIndexParts(string $key): array{
        $keys = preg_replace('/\s+/im', '', $key);
        $keys = str_replace(['->', '-', ','], '.', $keys);
        $keys = trim($keys, '.');
        return explode('.', $keys);
    }

    /**
     * Post verilerinin iç içe dizi mantığıyla alınmasını sağlar.
     *
     * @param string $indexes
     * @param $default
     * @return false|mixed|string
     */
    private function getPostDataFromArray(array $indexes, $default): mixed{
        $result = $this->postDatas;
        foreach($indexes as $index){
            if(empty($result[$index])){
                $result = $default;
                break;
            }
            $result = $result[$index];
        }
        return $result;
    }

}