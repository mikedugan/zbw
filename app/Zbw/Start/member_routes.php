<?php

Route::group(
  array('before' => 'controller'),
  function () {
      $cid = \Sentry::check() ? \Sentry::getUser()->cid : 0;
      //routes for the logged in users
      Route::get('news', ['as' => 'news', 'uses' => 'NewsController@getIndex']);

      Route::get('controllers/resources', ['as' => 'controllers.resources', 'uses' => 'StaticController@getControllersResources']);

      Route::post('/me/markallread',['as' => '/me/markallread', 'uses' => 'AjaxController@markInboxRead']);
      Route::get('changelog', function() {return View::make('zbw.changelog');});
      Route::get('/u/' . $cid,array('as' => 'me', 'uses' => 'UsersController@getMe'));
      Route::get('me/profile',['as' => 'profile', 'uses' => 'UsersController@getSettings']);
      Route::post('me/profile',['as' => 'profile', 'uses' => 'UsersController@postSettings']);
      //training and exam routes
      Route::get('training/request/all', ['as' => 'training/request/all', 'uses' => 'TrainingController@getAllRequests']);
      Route::get('training/request/new', ['as'   => 'training/new-request','uses' => 'TrainingController@getRequest']);
      Route::get('training/request/{id}',['as'   => 'training/view-request/{id}','uses' => 'TrainingController@showRequest']);
      Route::get('/training/review',['as' => 'training/sessions', 'uses' => 'ExamsController@getReview']);
      Route::post('/training/review/{eid}',['as'   => 'training/review-session','uses' => 'ExamsController@postComment']);
      Route::post('/e/request/{cid}/{eid}',['as'   => 'me/exam-requests/{eid}','uses' => 'AjaxController@requestExam']);
      Route::post('/me/request/vatusa',['as'   => 'me/request/vatusa','uses' => 'AjaxController@requestVatusaExam']);
      Route::post('/me/request-training', ['as'   => 'me/request-training','uses' => 'AjaxController@postTrainingRequest']);
      Route::get('/training/exam', ['as' => 'training/exam', 'uses' => 'ExamsController@takeExam']);
      Route::get('/training/local-exam', ['as' => 'training/local-exam', 'uses' => 'ExamsController@requestLocalExam']);
      Route::post('/training/exam', ['before' => 'csrf', 'as' => 'training/exam', 'uses' => 'ExamsController@gradeExam']);
      Route::get('/t/request/{tid}',['as'   => 'training/view-request/{tid}','uses' => 'TrainingController@showRequest']);
      Route::post('/t/request/{tid}/cancel',['as'   => 'training/cancel-request/{tid}','uses' => 'AjaxController@cancelTrainingRequest']);
      Route::post('/t/request/{tid}/drop',['as' => 'training/drop-request/{tid}', 'uses' => 'AjaxController@dropTrainingRequest']);
      Route::post('/t/request/{tid}/accept',['as'   => 'training/accept-request/{tid}','uses' => 'AjaxController@acceptTrainingRequest']);
      Route::get('training/{id}', ['as' => 'training/view-session', 'uses' => 'TrainingController@viewSession']);

      //private messaging
      Route::group(
        ['prefix' => 'messages'],
        function () {
            Route::get('/',['as' => 'messages', 'uses' => 'MessagesController@index']);
            Route::get('allread', ['as' => 'messages.allread', 'uses' => 'MessagesController@markAllRead']);
            Route::post('send',['as' => 'messages/send', 'uses' => 'MessagesController@store']);
            Route::post('m/{mid}',['as'   => 'messages/reply/{mid}','uses' => 'MessagesController@reply']);
            Route::get('m/{mid}/delete',['as' => 'messages/{mid}/delete', 'uses' => 'MessagesController@delete']);
            Route::get('m/{mid}/restore',['as'   => 'messages/{mid}/restore','uses' => 'MessagesController@restore']);
            Route::get('m/{mid}',['as' => 'messages/{mid}', 'uses' => 'MessagesController@viewMessage']);
        }
      );
  }
);
