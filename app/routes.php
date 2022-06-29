<?php
$Router = new \Atabasch\System\Router();



$Router->get('/', "Main")->name('anasayfa');
$Router->get('/home/show', "Main::show");
$Router->get('/home/edit/{id:number}', ['Main', 'edit'])->name('anasayfa-duzenle');
$Router->get('/home/delete', [\Atabasch\Controllers\Main::class, 'delete']);



$Router->run();
?>
