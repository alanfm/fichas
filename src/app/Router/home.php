<?php
use App\Controller\Home;

Route::get('/home', function() {
    (new Home())->index();
});

Route::get('/', function() {
    (new Home())->index();
});

Route::post('/pesquisar', function() {
    (new Home())->search();
});