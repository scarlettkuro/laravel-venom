<?php

Route::get('auth',[
  'as' => 'google.auth', 'uses' => 'Auth\AuthController@redirectToProvider'
]);
Route::get('auth/callback',[
  'as' => 'google.callback', 'uses' => 'Auth\AuthController@handleProviderCallback'
]);