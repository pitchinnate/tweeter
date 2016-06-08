<?php

Route::get('/users/oauth','UserController@getLink');
Route::get('/users/oauth/return',['as'=>'twitter.callback','uses'=>'UserController@returnOauth']);

Route::group(['middleware' => ['oauth']],function(){

});
