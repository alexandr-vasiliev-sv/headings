<?php

Route::get('headings', 'HeadingsController@index');

Route::get('headings/{heading}', 'HeadingsController@show');

Route::get('headings/{heading}/posts', 'PostsController@posts');

Route::post('headings/{heading}/posts', 'PostsController@store')
    ->middleware('auth');

Route::post('headings/{heading}/subscribe', 'HeadingsController@subscribeOrUnSubscribe')
    ->middleware('auth');