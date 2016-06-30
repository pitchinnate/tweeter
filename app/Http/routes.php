<?php

Route::get('/users/oauth','UserController@getLink');
Route::get('/users/oauth/return',['as'=>'twitter.callback','uses'=>'UserController@returnOauth']);

Route::group(['middleware' => ['cors','oauth']],function(){
    Route::get('/users/status','UserController@getStatus');
    Route::get('/tweets','TweetController@getIndex');
    Route::post('/tweets','TweetController@postTweet');
    Route::get('/tweets/{id}',['middleware'=>['tweet'],'uses'=>'TweetController@getTweet']);
    Route::put('/tweets/{id}',['middleware'=>['tweet'],'uses'=>'TweetController@putTweet']);
    Route::delete('/tweets/{id}',['middleware'=>['tweet'],'uses'=>'TweetController@deleteTweet']);
});
