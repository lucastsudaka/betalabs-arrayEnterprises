<?php

use Illuminate\Http\Request;

// v1 da nossa API.
Route::prefix('v1')->group(function(){
        /**
         * 
         * Auth & usuario logado (current user)
         * 
         */
        Route::post('auth/login', 'api\AuthController@login');
        Route::post('auth/register', 'api\AuthController@register');
        
        // Ações do usuário logado (currentUser)
        Route::group(['middleware' => ['check.role:basic,admin']], function() {
            Route::get('currentUser', 'api\CurrentUserController@index');
            Route::put('currentUser', 'api\CurrentUserController@update');
            Route::post('currentUser/photo', 'api\CurrentUserController@uploadPhoto');

          #  Route::post('auth/currentUser/profileImage', 'api\AuthController@updateProfileImage');

        });
        
        
        /**
         * 
         * Comentários
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



