<?php

Route::namespace('Contents')->group(function () {

    Route::get('articles', 'ArticleController@all');
    Route::get('videos', 'VideoController@all');
    Route::get('discussions', 'DiscussionController@all');

    Route::get('article/{id}', 'ArticleController@get');
    Route::get('video/{id}', 'VideoController@get');
    Route::get('discussion/{id}', 'DiscussionController@get');
});
