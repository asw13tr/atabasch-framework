<?php

require_once(__DIR__.'/vendor/autoload.php');

$rootInit = new \Atabasch\System\Init;
$rootInit->run();


$Router = new \Atabasch\System\Router;

$Router->get('/', function(){
    echo "naber";
});


$Router->get('/users', function(){
    echo "Burası kullanıcılar sayfası";
});

$Router->get('/posts', function(){
    echo "Burası Makaleler sayfası";
});

$Router->get('/post/{slug}/show', function(){
    echo "Burası Makaleler sayfası detayı";
});

$Router->get('/user', function(){
    echo "Burası üye düzenleme  sayfası";
});


$Router->get('/user/{int}/edit', function($id){
    echo "Burası üye düzenleme  sayfası ID no: $id";
});

$Router->run();

phpinfo();
?>
