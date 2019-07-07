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
        Route::post('auth/login', 'Api\AuthController@login');
        // registrar
        Route::post('auth/register', 'Api\AuthController@register');
        
        
        /**
         * 
         * Current user - Usuário autenticado
         * 
         */
        // Ações do usuário logado (currentUser)
        Route::group(['middleware' => ['check.role:basic,admin']], function() {
            // retornar atual usuário
            Route::get('currentUser', 'Api\CurrentUserController@index');
            // atualizar o usuário
            Route::put('currentUser', 'Api\CurrentUserController@update');
            // atualizar a foto de perfil
            Route::post('currentUser/photo', 'Api\CurrentUserController@uploadPhoto');


        });
        
        
        /**
         * 
         * Comentários -> Utilizando resource
         * 
         */   
        Route::resource('comments','Api\CommentController')->only([    
            'index', 'show'
        ]);
        Route::group(['middleware' => ['check.role:basic,admin']], function() {
            Route::resource('comments','Api\CommentController')->only([      
                'store', 'update', 'destroy'
            ]);
        }); 
        



});



