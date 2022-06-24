<?php
$Router = new \Atabasch\System\Router;

$Router->get('/', "Home::index")->name('anasayfa');


$Router->get('/users', function(){
    echo "Burası kullanıcılar sayfası";
})->name('uyeler');

$Router->get('/posts', function(){
    echo "Burası Makaleler sayfası";
});

$Router->get('/post/{slug}/show', function(){
    echo "Burası Makaleler sayfası detayı";
})->name('post.detail');

$Router->get('/users', function(){
    echo "Burası üyelerin listelendiği sayfa";
})->name('users');


$Router->get('/user/edit/{int}?', ["Home", "edit"])->name('user.edit');


$Router->set404("Error::notfound");

$Router->run();
?>
