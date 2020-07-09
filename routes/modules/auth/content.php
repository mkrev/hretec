<?php
Route::namespace('Contents')->group(function () {

    /*Route::post('create/article', 'ArticleController@updateOrCreate');
    Route::post('create/video', 'VideoController@updateOrCreate');
    Route::post('create/discussion', 'DiscussionController@updateOrCreate');

    Route::middleware(['formdata'])->group(function () {
    Route::patch('update/article/{id}', 'ArticleController@updateOrCreate');
    Route::patch('update/video/{id}', 'VideoController@updateOrCreate');
    Route::patch('update/discussion/{id}', 'DiscussionController@updateOrCreate');
    });*/

    Route::get('user/articles', 'ArticleController@userAll');
    Route::get('user/videos', 'VideoController@userAll');
    Route::get('user/discussions', 'DiscussionController@userAll');

    Route::post('update-or-create/article/{id?}', 'ArticleController@updateOrCreate');
    Route::post('update-or-create/video/{id?}', 'VideoController@updateOrCreate');
    Route::post('update-or-create/discussion/{id?}', 'DiscussionController@updateOrCreate');

    Route::delete('article/{id}', 'ArticleController@delete');
    Route::delete('video/{id}', 'VideoController@delete');
    Route::delete('discussion/{id}', 'DiscussionController@delete');

    Route::get('edit/article/{id}', 'ArticleController@edit');
    Route::get('edit/video/{id}', 'VideoController@edit');
    Route::get('edit/discussion/{id}', 'DiscussionController@edit');

    Route::post('article/{id}/add-comment', 'ArticleController@addComment');
    Route::post('video/{id}/add-comment', 'VideoController@addComment');
    Route::post('discussion/{id}/add-comment', 'DiscussionController@addComment');

    Route::post('article/{id}/add-like', 'ArticleController@addLike');
    Route::post('video/{id}/add-like', 'VideoController@addLike');
    Route::post('discussion/{id}/add-like', 'DiscussionController@addLike');

    Route::get('user/articles', 'ArticleController@userAll');
    Route::get('user/videos', 'VideoController@userAll');
    Route::get('user/discussions', 'DiscussionController@userAll');

    Route::get('user/article/{id}/get-like', 'ArticleController@getLike');
    Route::get('user/video/{id}/get-like', 'VideoController@getLike');
    Route::get('user/discussion/{id}/get-like', 'DiscussionController@getLike');

    Route::post('comment/{id}/add-like', 'CommentController@addLike');
    Route::delete('comment/{id}', 'CommentController@delete');
    Route::patch('comment/update/{id}', 'CommentController@update');
});
