<?php

use Zbw\Http\Controllers\TrainingRequestController;
use Zbw\Http\Controllers\NewsController;
use Zbw\Http\Controllers\MessagesController;
use Zbw\Http\Controllers\UsersController;
use Zbw\Http\Controllers\TrainingController;
use Zbw\Http\Controllers\ExamsController;
use Zbw\Http\Controllers\ScheduleController;

Route::group(
  array('before' => 'controller'),
  function () {
      $cid = \Sentry::check() ? \Sentry::getUser()->cid : 0;
      //routes for the logged in users
      Route::get('news', ['as' => 'news', 'uses' => NewsController::class.'@getIndex']);

      Route::post('/me/markallread', ['as' => '/me/markallread', 'uses' => MessagesController::class.'@aMarkInboxRead']);
      Route::get('changelog', function() {return \View::make('zbw.changelog');});
      Route::get('/u/' . $cid, array('as' => 'me', 'uses' => UsersController::class.'@getMe'));
      Route::get('me/profile', ['as' => 'profile', 'uses' => UsersController::class.'@getSettings']);
      Route::post('me/profile', ['as' => 'profile', 'uses' => UsersController::class.'@postSettings']);
      //training and exam routes
      Route::get('training/request/all', ['as' => 'training/request/all', 'uses' => TrainingController::class.'@getAllRequests']);
      Route::get('training/request/new', ['as'   => 'training/new-request', 'uses' => TrainingController::class.'@getRequest']);
      Route::get('training/request/{id}', ['as'   => 'training/view-request/{id}', 'uses' => TrainingController::class.'@showRequest']);
      Route::get('training/request/{id}/cancel', ['as' => 'training/request/cancel', 'uses' => TrainingController::class.'@postCancelRequest']);
      Route::get('/training/review', ['as' => 'training/sessions', 'uses' => ExamsController::class.'@getReview']);
      Route::post('/training/review/{eid}', ['as'   => 'training/review-session', 'uses' => ExamsController::class.'@postComment']);
      Route::post('/e/request/{cid}/{eid}', ['as'   => 'me/exam-requests/{eid}', 'uses' => ExamsController::class.'@aRequestExam']);
      Route::post('/me/request/vatusa', ['as'   => 'me/request/vatusa', 'uses' => ExamsController::class.'@aRequestVatusa']);
      Route::post('/me/request-training', ['as'   => 'me/request-training', 'uses' => TrainingRequestController::class.'@postTrainingRequest']);
      Route::get('/training/exam', ['as' => 'training/exam', 'uses' => ExamsController::class.'@takeExam']);
      Route::get('/training/local-exam', ['as' => 'training/local-exam', 'uses' => ExamsController::class.'@requestLocalExam']);
      Route::post('/training/exam', ['before' => 'csrf', 'as' => 'training/exam', 'uses' => ExamsController::class.'@gradeExam']);
      Route::get('/t/request/{tid}', ['as'   => 'training/view-request/{tid}', 'uses' => TrainingController::class.'@showRequest']);
      Route::post('/t/request/{tid}/cancel', ['as'   => 'training/cancel-request/{tid}', 'uses' => TrainingRequestController::class.'@cancelTrainingRequest']);
      Route::post('/t/request/{tid}/drop', ['as' => 'training/drop-request/{tid}', 'uses' => TrainingRequestController::class.'@dropTrainingRequest']);
      Route::post('/t/request/{tid}/accept', ['as'   => 'training/accept-request/{tid}', 'uses' => TrainingRequestController::class.'@acceptTrainingRequest']);
      Route::get('training/{id}', ['as' => 'training/view-session', 'uses' => TrainingController::class.'@viewSession']);

      //private messaging
      Route::group(['prefix' => 'messages'], function () {
          Route::get('/', ['as' => 'messages', 'uses' => MessagesController::class.'@index']);
          Route::post('/', ['as' => 'messages.action', 'uses' => MessagesController::class.'@postAction']);
          Route::get('allread', ['as' => 'messages.allread', 'uses' => MessagesController::class.'@markAllRead']);
          Route::post('send', ['as' => 'messages/send', 'uses' => MessagesController::class.'@store']);
          Route::post('m/{mid}', ['as'   => 'messages/reply/{mid}', 'uses' => MessagesController::class.'@reply']);
          Route::get('m/{mid}/delete', ['as' => 'messages/{mid}/delete', 'uses' => MessagesController::class.'@delete']);
          Route::get('m/{mid}/restore', ['as'   => 'messages/{mid}/restore', 'uses' => MessagesController::class.'@restore']);
          Route::get('m/{mid}', ['as' => 'messages/{mid}', 'uses' => MessagesController::class.'@viewMessage']);
        });

      Route::group(['prefix' => 'schedule'], function() {
          Route::get('/', ['as' => 'scheduler.index', 'uses' => ScheduleController::class.'@getIndex']);
          Route::post('/', ['as' => 'scheduler.create', 'uses' => ScheduleController::class.'@postIndex']);
          Route::get('delete/{id}', ['as' => 'scheduler.delete', 'uses' => ScheduleController::class.'@getDelete']);
      });
  }
);
