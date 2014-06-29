<?php

Route::group(
  array('before' => 'controller'), function () {
      $cid = is_null(Auth::user()) ? 0 : Auth::user()->cid;
      //routes for the logged in users
      Route::get('me', 'ControllersController@getMe');
      Route::post('/me/markallread', 'AjaxController@markInboxRead');
      Route::get('/u/' . $cid,array('as' => 'me', 'uses' => 'ControllersController@getMe'));
      Route::get('me/profile', 'ControllersController@getSettings');
      //training and exam routes
      Route::get('training/request/new', 'TrainingController@getRequest');
      Route::get('training/request/{id}', 'TrainingController@showRequest');
      Route::get('/training/review', 'TrainingController@getReview');
      Route::post('/training/review/{eid}', 'ControllerExamsController@postComment');
      Route::post('/e/request/{cid}/{eid}',array('uses' => 'AjaxController@requestExam'));
      Route::post('/t/request/new', 'AjaxController@postTrainingRequest');
      Route::get('/t/request/{tid}', 'TrainingController@showRequest');
      Route::post('/t/request/{tid}/cancel','AjaxController@cancelTrainingRequest');
      Route::post('/t/request/{tid}/accept','AjaxController@acceptTrainingRequest');
      Route::post('/f/upload/photos', 'AjaxController@photoUpload');
      //private messaging
      Route::group(
        ['prefix' => 'messages'], function () {
            Route::get('/', 'MessagesController@index');
            Route::get('m/{mid}', 'MessagesController@view');
            Route::get('m/{mid}', 'MessagesController@view');
            Route::post('send', 'MessagesController@store');
            Route::post('m/{mid}', 'MessagesController@reply');
        });
  });
