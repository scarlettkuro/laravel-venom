<?php

Route::get('/', [ 'as' => 'home', 'uses' => 'PostController@index' ]);
/*
 * OAuth
 */
Route::get('login',[ 'as' => 'login', 'uses' => 'Auth\AuthController@login' ]);
Route::get('auth',[ 'as' => 'auth', 'uses' => 'Auth\AuthController@auth' ]);
Route::get('logout',[ 'as' => 'logout', 'uses' => 'Auth\AuthController@logout' ]);
/*
 * User Managment
 */
Route::post('user',[  
  'middleware' => 'auth', 'as' => 'update-user', 'uses' => 'Auth\AuthController@updateUser' ]);
/*
 * Post managment
 */
    /*
     * Editing
     */
Route::post('post/create',[  
  'middleware' => 'auth', 'as' => 'create-post', 'uses' => 'PostController@createPost' ]);

Route::post('post/update/{id}',[ 
  'middleware' => 'auth', 'as' => 'update-post', 'uses' => 'PostController@updatePost' ])
        ->where('id', '[0-9]+');

Route::get('post/private/{id}',[ 
  'middleware' => 'auth', 'as' => 'private-post', 'uses' => 'PostController@privatePost' ])
        ->where('id', '[0-9]+');

Route::get('post/delete/{id}',[ 
  'middleware' => 'auth', 'as' => 'delete-post', 'uses' => 'PostController@deletePost' ])
        ->where('id', '[0-9]+');
    /*
     * Read
     */
Route::get('read/{id}',[ 'as' => 'read-post', 'uses' => 'PostController@readPost' ])
        ->where('id', '[0-9]+');

Route::get('edit/{id}',[ 'as' => 'edit-post', 'uses' => 'PostController@editPost' ])
        ->where('id', '[0-9]+');

Route::get('{nickname}/{page?}', [ 'as' => 'blog', 'uses' => 'PostController@blog'])
        ->where('page', '[0-9]+');