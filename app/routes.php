<?php
$Router = new \Atabasch\System\Router();



$Router->name('frontpage')->get('/', "Main");
$Router->get('/users', "Main", ['name' => 'users']);
$Router->middleware(['UserLogin', 'Admin'])->get('/posts', "Main");
$Router->post('/post/add', "Main", ['name' => 'post.add']);
$Router->name('post.delete')->post('/post/delete', "Main");

$Router->prefix('/admin')->name('admin.')->middleware(['Admin', 'Yonetici', 'Login'])->group(function($router){

    $router->get('/', function(){
       echo "Admin";
    });

    $router->prefix('/user')->name('user.')->middleware(['User', 'UserLogin', 'Admin'])->group(function($router){
        $router->name('list')->get('/list', 'Admin\Users::list');
        $router->name('edit')->middleware(['User', 'UserEdit'])->get('/edit/{username:string}/{id:int}', 'Admin\Users::edit');
    });

    $router->get('posts', "Main::posts", ['name'=>'posts']);
    $router->get('comments', "Main::comments", ['name'=>'comments']);

});


$Router->get('/pages', "Main::pages");


$Router->setError(function(){
    echo '404 Not Found -> Sayfa  Bulunamadı';
});



$Router->run();

?>
