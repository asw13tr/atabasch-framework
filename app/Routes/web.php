<?php

use \Atabasch\Core\Routing\RouteCollection as Route;
$route = new Route();

$response = new Atabasch\Core\Response();



$route->get('/', 'Main', ['as' => 'homepage']);
$route->get('/about', 'Atabasch\Controllers\Main::about', ['as' => 'about']);
$route->get('/gallery/{id:int}', [\Atabasch\Controllers\Main::class, 'Gallery'], ['domain'=>'asw.atabasch.com']);
$route->get('/contact', 'Main::contact', ['as' => 'contact']);
$route->post('/contact', 'Main::contactPost', ['as' => 'contact.post']);
$route->redirect('/hakkimizda', '/about');
$route->redirect('/google', 'http://google.com');

$route->get('/user/{id:int}/edit', function($id){
    echo $id;
});

$panelOpt = [
    'as'            => 'panel.',
    'middleware'    => ['AdminCheck', 'LoginCheck'],
    'domain'        => 'admin.atabasch.com',
    'namespace'     => 'Atabasch\Controllers\Admin',

];
$route->group('/admin', $panelOpt, function($route){
    $route->get('', 'Main::index', ['as' => 'dashboard']);


    $route->get('/posts', 'Post::index', ['middleware'=>['PostMiddleware', 'GonderiMware', 'AdminCheck']]);
    $route->get('/users', 'User::index', ['as' => 'users']);
    $route->get('/comments', 'Comment::index');
});

$route->error("Atabasch\Controllers\Main::about");

$route->run();


?>
