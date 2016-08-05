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
Route::post('user',[ 'as' => 'update-user', 'uses' => 'Auth\AuthController@updateUser' ]);
/*
 * Post managment
 */
Route::post('post',[ 'as' => 'create-post', 'uses' => 'PostController@createPost' ]);
Route::post('post/{id}',[ 'as' => 'update-post', 'uses' => 'PostController@updatePost' ]);
Route::get('post/{id}',[ 'as' => 'edit-post', 'uses' => 'PostController@readPost' ]);
Route::get('post/private/{id}',[ 'as' => 'private-post', 'uses' => 'PostController@privatePost' ]);
Route::get('post/delete/{id}',[ 'as' => 'delete-post', 'uses' => 'PostController@deletePost' ]);
Route::get('/{nickname}/{page?}', [ 'as' => 'blog', 'uses' => 'PostController@blog'])
        ->where('page', '[0-9]+');