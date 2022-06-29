<?php

namespace Atabasch\System;
use \Atabasch\System\HttpStatusCode;

class Response{

    private string $pathViews = __DIR__.'/../Views';

    private string $urlPattern = '@^https?:\/\/|^ftp:\/\/|^www\.|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}@imu';

    /**
     * Status Codeları
     *
     * @return \Atabasch\System\HttpStatusCode
     */
    public function httpStatusCode(): \Atabasch\System\HttpStatusCode{
        return new HttpStatusCode();
    }

    /**
     * Statuscode değil yada al
     *
     * @param $code
     * @return Response
     */
    public function statusCode($code=null): Response{
        if(!$code){
            return http_response_code();
        }else{
            http_response_code($code);
        }
        return $this;
    }

    /**
     * Views dizininden php dosyaları çalıştırır.
     *
     * @param string|null $viewFileName views dizini içinde var olan bir php dosya adı.
     * @param array $datas çalıştırılan view dosyası içinde kullanılacak değişkenler dizisi.
     * @param int $statusCode
     * @return Response
     */
    public function view(string $viewFileName=null, array $datas=[], int $statusCode=200): Response{
        $this->statusCode($statusCode);
        if(!file_exists($this->getFilePath($viewFileName))){
            echo "Not found: ".$this->getFilePath($viewFileName);
        }else{
            ob_start();
            extract($datas);
            include_once $this->getFilePath($viewFileName);
            echo ob_get_clean();
        }
        return $this;
    }

    /**
     * View dosyası php uzantısı düzenleme
     *
     * @param string $fileName
     * @return string
     */
    public function getFilePath(string $fileName=''): string{
        $fileName =  basename($fileName, '.php').'.php';
        return trim($this->pathViews, '/').'/'.$fileName;
    }

    /**
     * Datas değişkenini ekrana json formatında basar.
     *
     * @param array $datas
     * @return Response
     */
    public function json(array $datas=[]): Response{
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($datas);
        return $this;
    }

    /**
     * Bir dosya indirme sayfası oluşturur.
     *
     * @param string $fileUrl
     * @param string|null $fileName
     * @return $this
     */
    public function download(string $fileUrl, string $fileName=null): Response{
        $fileName = $fileName ?? basename($fileUrl);
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" .$fileName. "\"");
        readfile($fileUrl);
        return $this;
    }

    public function redirect(string $urlOrPath='', int $time=0, int $responseCode=0): Response{
        $redirectUrl = $urlOrPath;
        if(!preg_match($this->urlPattern, $urlOrPath)){
            $url = new \Atabasch\System\Url();
            $redirectUrl = $url->get($urlOrPath);
        }

        if($time<1){
            header('Location:'.$redirectUrl, true, $responseCode);
        }else{
            header("Refresh:{$time}; url={$redirectUrl}", true, $responseCode);
        }
        return $this;
    }


}