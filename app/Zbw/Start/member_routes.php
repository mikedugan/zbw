<?php

Route::group(
  array('before' => 'controller'),
  function () {
      $cid = is_null(Auth::user()) ? 0 : Auth::user()->cid;
      //routes for the logged in users
      Route::post(
        '/me/markallread',
        ['as' => '/me/markallread', 'uses' => 'AjaxController@markInboxRead']
      );
      Route::get(
        '/u/' . $cid,
        array('as' => 'me', 'uses' => 'ControllersController@getMe')
      );
      Route::get(
        'me/profile',
        ['as' => 'profile', 'uses' => 'ControllersController@getSettings']
      );
      Route::post(
        'me/profile',
        ['as' => 'profile', 'uses' => 'ControllersController@postSettings']
      );
      //training and exam routes
      Route::get(
        'training/request/new',
        [
          'as'   => 'training/new-request',
          'uses' => 'TrainingController@getRequest'
        ]
      );
      Route::get(
        'training/request/{id}',
        [
          'as'   => 'training/view-request/{id}',
          'uses' => 'TrainingController@showRequest'
        ]
      );
      Route::get(
        '/training/review',
        ['as' => 'training/sessions', 'uses' => 'TrainingController@getReview']
      );
      Route::post(
        '/training/review/{eid}',
        [
          'as'   => 'training/review-session',
          'uses' => 'ControllerExamsController@postComment'
        ]
      );
      Route::post(
        '/e/request/{cid}/{eid}',
        [
          'as'   => 'me/exam-requests/{eid}',
          'uses' => 'AjaxController@requestExam'
        ]
      );
      Route::post(
        '/t/request/new',
        [
          'as'   => 'me/request-training',
          'uses' => 'AjaxController@postTrainingRequest'
        ]
      );
      Route::get(
        '/t/request/{tid}',
        [
          'as'   => 'training/view-request/{tid}',
          'uses' => 'TrainingController@showRequest'
        ]
      );
      Route::post(
        '/t/request/{tid}/cancel',
        [
          'as'   => 'training/cancel-request/{tid}',
          'uses' => 'AjaxController@cancelTrainingRequest'
        ]
      );
      Route::post(
        '/t/request/{tid}/accept',
        [
          'as'   => 'training/accept-request/{tid}',
          'uses' => 'AjaxController@acceptTrainingRequest'
        ]
      );
      //private messaging
      Route::group(
        ['prefix' => 'messages'],
        function () {
            Route::get(
              '/',
              ['as' => 'messages', 'uses' => 'MessagesController@index']
            );
            Route::get(
              'm/{mid}',
              ['as' => 'messages/{mid}', 'uses' => 'MessagesController@view']
            );
            Route::post(
              'send',
              ['as' => 'messages/send', 'uses' => 'MessagesController@store']
            );
            Route::post(
              'm/{mid}',
              [
                'as'   => 'messages/reply/{mid}',
                'uses' => 'MessagesController@reply'
              ]
            );
        }
      );
  }
);
