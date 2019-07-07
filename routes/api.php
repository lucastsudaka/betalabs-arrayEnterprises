<?php

use Illuminate\Http\Request;

// Versão 1 da  API.
Route::prefix('v1')->group(function(){
        /**
         * 
         * Auth 
         * 
         */
        // login
        Route::post('auth/login', 'api\AuthController@login');
        // registrar
        Route::post('auth/register', 'api\AuthController@register');
        
        
        /**
         * 
         * Current user - Usuário autenticado
         * 
         */
        // Ações do usuário logado (currentUser)
        Route::group(['middleware' => ['check.role:basic,admin']], function() {
            // retornar atual usuário
            Route::get('currentUser', 'api\CurrentUserController@index');
            // atualizar o usuário
            Route::put('currentUser', 'api\CurrentUserController@update');
            // atualizar a foto de perfil
            Route::post('currentUser/photo', 'api\CurrentUserController@uploadPhoto');


        });
        
        
        /**
         * 
         * Comentários -> Utilizando resource
         * 
         */   
        Route::resource('comments','api\CommentController')->only([    
            'index', 'show'
        ]);
        Route::group(['middleware' => ['check.role:basic,admin']], function() {
            Route::resource('comments','api\CommentController')->only([      
                'store', 'update', 'destroy'
            ]);
        }); 
        



});



