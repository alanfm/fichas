<?php

use App\Controller\Alunos;

Route::group(['prefix' => 'alunos'], function() {
    Route::get('/', function() {
        (new Alunos())->index();
    });

    Route::get('/{id}', function($id) {
        (new Alunos())->verify($id);
    });

    Route::post('/', function() {
        (new Alunos())->create();
    });

    Route::get('/editar/{id}', function($id) {
        (new Alunos())->edit($id);
    });

    Route::post('/editar/{id}', function($id) {
        (new Alunos())->update($id);
    });

    Route::get('/apagar/{id}', function($id) {
        (new Alunos())->delete($id);
    });

    Route::post('/pesquisar', function() {
        (new Alunos())->search();
    });

    Route::get('/pagina/{page}', function($page) {
        (new Alunos())->pagination($page);
    });
});