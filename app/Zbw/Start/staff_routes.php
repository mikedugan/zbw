<?php

use Zbw\Http\Controllers\AdminController;
use Zbw\Http\Controllers\EmailController;
use Zbw\Http\Controllers\FeedbackController;
use Zbw\Http\Controllers\MenusController;
use Zbw\Http\Controllers\NewsController;
use Zbw\Http\Controllers\PagesController;
use Zbw\Http\Controllers\StaffingController;
use Zbw\Http\Controllers\TeamspeakController;
use Zbw\Http\Controllers\UsersController;
use Zbw\Http\Controllers\TrainingController;
use Zbw\Http\Controllers\ExamsController;
use Zbw\Http\Controllers\RosterController;
use Zbw\Http\Controllers\PokerController;
use Zbw\Http\Controllers\VisitorController;

Route::group(
  ['before' => 'auth|staff'], function () {
    Route::group(['before' => 'executive'], function () {
        Route::post('/staff/poker/wipe', PokerController::class.'@postWipe');
        Route::post('r/activate/{cid}', ['as' => 'controllers/{cid}/active', 'uses' => UsersController::class.'@aActivate']);
        Route::post('r/suspend/{cid}', ['as' => 'controllers/{cid}/suspend', 'uses' => UsersController::class.'@aSuspend']);
        Route::post('r/terminate/{cid}', ['as' => 'controllers/{cid}/terminate', 'uses' => UsersController::class.'@aTerminate']);
        Route::post('r/promote/{cid}', ['as' => 'controllers/{cid}/promote', 'uses' => UsersController::class.'@aPromote']);
        Route::post('r/demote/{cid}', ['as' => 'controllers/{cid}/demote', 'uses' => UsersController::class.'@aDemote']);
        Route::post('/m/staff-welcome/{cid}',
            ['as' => 'controllers/{cid}/staff-welcome', 'uses' => UsersController::class.'@sendStaffWelcome']);
        Route::get('/staff/super/mike/{cid}',
            ['as' => 'staff/super/mike/{cid}', 'uses' => AdminController::class.'@getOverride']);
        Route::get('/staff/admin', ['as' => 'staff.admin', 'uses' => AdminController::class.'@getAdmin']);

        Route::get('/staff/emails', ['as' => 'staff.emails', 'uses' => EmailController::class.'@getIndex']);
        Route::get('/staff/emails/edit', ['as' => 'staff.emails.edit', 'uses' => EmailController::class.'@getEdit']);
        Route::post('/staff/emails/edit', ['as' => 'staff.emails.edit', 'uses' => EmailController::class.'@postEdit']);
    });
      Route::group(
        ['prefix' => 'staff'], function () {
            Route::get('live/{tsid}', TrainingController::class.'@testLiveSession');
            Route::post('live/{tsid}', TrainingController::class.'@postLiveSession');

            Route::get('/', ['as' => 'staff', 'uses' => AdminController::class.'@getAdminIndex']);
            Route::get('staffing', ['as' => 'staff/staffing', 'uses' => StaffingController::class.'@getIndex']);
            Route::get('exams/all', ['as' => 'staff/exams/all', 'uses' => ExamsController::class.'@getIndex']);
            Route::post('exams/review/{eid}', ['as' => 'exams/review/{eid}', 'uses' => ExamsController::class.'@postComment']);
            Route::get('training', ['as' => 'staff/training', 'uses' => TrainingController::class.'@getAdminIndex']);
            Route::get('training/new', ['as' => 'training.new', 'uses' => TrainingController::class.'@getNewSession']);
            Route::post('training/new', ['as' => 'training.new', 'uses' => TrainingController::class.'@postNewSession']);
            Route::get('training/all', ['as' => 'staff/training/all', 'uses' => TrainingController::class.'@getAll']);
            Route::get('training/availability', ['as' => 'staff.availability', 'uses' => TrainingController::class.'@getStaffStaffAvailability']);
            Route::post('training/availability', ['as' => 'staff.availability', 'uses' => TrainingController::class.'@postStaffAvailability']);
            Route::get('training/availability/delete/{id}', ['as' => 'staff.availability.delete', 'uses' => TrainingController::class.'@getDeleteAvailability']);

            Route::get('exams/review/{eid}', ['as' => 'exams/review/{eid}', 'uses' => ExamsController::class.'@getStaffReview']);
            Route::get('exams/questions', ['as' => 'staff/exams/questions', 'uses' => ExamsController::class.'@getQuestions']);
            Route::get('exams/questions/{id}', ['as' => 'staff/exams/questions/{id}', 'uses' => ExamsController::class.'@getEditQuestion']);
            Route::post('exams/questions/{id}', ['as' => 'staff/exams/questions/{id}', 'uses' => ExamsController::class.'@postEditQuestion']);
            Route::post('exams/questions/{id}/delete', ['as' => 'staff/exams/questions/{id}/delete', 'uses' => ExamsController::class.'@deleteQuestion']);
            Route::post('exams/questions', ['as' => 'exams/add-question', 'uses' => ExamsController::class.'@addQuestion']);
            Route::get('adopt/{cid}', ['as' => 'staff/adopt/{cid}', 'uses' => TrainingController::class.'@getAdopt']);
            Route::post('adopt/{cid}', ['as' => 'staff/adopt/{cid}', 'uses' => TrainingController::class.'@postAdopt']);
            Route::post('adopt/{cid}/drop', ['as' => 'staff/adopt/{cid}/drop', 'uses' => TrainingController::class.'@getDropAdopt']);
            Route::get('roster', ['as' => 'roster', 'uses' => RosterController::class.'@getAdminIndex']);
            Route::post('rotser', ['as' => 'roster.add', 'uses' => RosterController::class.'@postAddController']);
            Route::post('roster/groups/add', ['as' => 'staff/roster/add-group', 'uses' => RosterController::class.'@postGroup']);
            Route::post('roster/groups/update', ['as' => 'staff/roster/edit-group', 'uses' => RosterController::class.'@updateGroup']);
            Route::get('roster/results', ['roster/search', 'uses' => AdminController::class.'@getSearchResults']);
            Route::get('roster/vatusa_exams/{cid}', ['as' => 'staff/roster/vatusa_exams/{cid}', 'uses' => ExamsController::class.'@aGetVatusaExams']);
            Route::get('u/{id}', ['roster/user/{id}', 'uses' => UsersController::class.'@showUser']);
            Route::get('{id}/edit', ['as' => 'roster/user/{id}/edit', 'uses' => RosterController::class.'@getEditUser']);
            Route::post('{id}/edit', ['as' => 'staff/{id}/edit', 'uses' => RosterController::class.'@postEditUser']);
            Route::get('{id}/training', ['as' => 'roster/user/{id}/training', 'uses' => RosterController::class.'@getControllerDashboard']);
            Route::post('{id}/comment', ['as' => 'staff/{id}/comment', 'uses' => RosterController::class.'@postRosterComment']);
            Route::post('{id}/exam-records', ['as' => 'roster.exam-records', 'uses' => RosterController::class.'@postExamRecords']);
            Route::get('comments/{comment}/delete', ['as' => 'staff/comments/{comment}/delete', 'uses' => RosterController::class.'@getDeleteComment']);
            Route::get('comments/{comment}/edit', ['as' => 'staff/comments/{comment}/edit', 'uses' => RosterController::class.'@getEditComment']);
            Route::post('comments/{comment}/edit', ['as' => 'staff/comments/{comment}/edit', 'uses' => RosterController::class.'@postEditComment']);
            Route::get('roster/create-controller', ['as' => 'roster/add', 'uses' => RosterController::class.'@getAddController']);
            Route::get('pages', ['as' => 'staff/pages', 'uses' => PagesController::class.'@getIndex']);
            Route::get('pages/create', ['as' => 'staff/pages/create', 'uses' => PagesController::class.'@getCreate']);
            Route::post('pages/create', ['as' => 'staff/pages/create', 'uses' => PagesController::class.'@postCreate']);
            Route::post('pages/edit', ['as' => 'staff/pages/edit', 'uses' => PagesController::class.'@postEdit']);
            Route::get('forum', ['as' => 'staff/forum', 'uses' => AdminController::class.'@getForumIndex']);
            Route::get('ts', ['as' => 'staff/ts', 'uses' => AdminController::class.'@getTsIndex']);

            Route::get('poker', ['as' => 'poker', 'uses' => PokerController::class.'@getIndex']);
            Route::post('poker', ['as' => 'poker', 'uses' => PokerController::class.'@postIndex']);
            Route::get('poker/{id}', ['as' => 'poker/{id}', 'uses' => PokerController::class.'@getPilot']);

            Route::get('news', ['as' => 'staff/news', 'uses' => NewsController::class.'@getAdminIndex']);
            Route::get('news/add', ['as' => 'news/add', 'uses' => NewsController::class.'@getCreate']);
            Route::post('news/add', ['as' => 'news/add', 'uses' => NewsController::class.'@postCreate']);

            Route::get('log', ['as' => 'log', 'uses' => AdminController::class.'@getLog']);

            Route::get('news/{id}/edit', ['as' => 'news/{id}/edit', 'uses' => NewsController::class.'@getEdit']);
            Route::post('news/{id}/edit', ['as' => 'news/{id}/edit', 'uses' => NewsController::class.'@postEdit']);
            //this route is deprecated
            //Route::post('/a/complete/{aid}', 'AjaxController@actionCompleted');

            Route::get('pages/create', ['as' => 'pages/create', 'uses' => PagesController::class.'@getCreate']);
            Route::get('pages/view', ['as' => 'pages/view', 'uses' => PagesController::class.'@getShow']);
            Route::get('pages/trash', ['as' => 'pages/trash', 'uses' => PagesController::class.'@getTrash']);

            Route::post('pages/menus/create', ['as' => 'menus/create', 'uses' => MenusController::class.'@postCreate']);
            Route::get('pages/menus', ['as' => 'menus', 'uses' => MenusController::class.'@getIndex']);
            Route::get('pages/menus{mid}/edit', ['as' => 'menus/{mid}/edit', 'uses' => MenusController::class.'@getUpdate']);
            Route::post('pages/menus/{mid}/update', ['as' => 'menus/{mid}/edit', 'uses' => MenusController::class.'@postUpdate']);
            Route::get('pages/menus/{mid}/delete', ['as' => 'menus/{mid}/delete', 'uses' => MenusController::class.'@postDelete']);
            Route::post('exams/review/{id}/complete', ['as' => 'exams/review/{id}/complete', 'uses' => ExamsController::class.'@aExamReviewed']);
            Route::post('exams/review/{id}/reopen', ['as' => 'exams/review/{id}/reopen', 'uses' => ExamsController::class.'@aReopenExam']);
            Route::post('visitor/accept/{id}', ['as' => 'staff/visitor/accept/{id}', 'uses' => VisitorController::class.'@postVisitorAccept']);
            Route::post('visitor/deny', ['as' => 'staff/visitor/deny', 'uses' => RosterController::class.'@postVisitorDeny']);
            Route::post('visitor/lor', ['as' => 'staff/visitor/lor', 'uses' => RosterController::class.'@postVisitorLor']);
            Route::post('visitor/comment', ['as' => 'staff/visitor/comment', 'uses' => RosterController::class.'@postVisitorComment']);
            Route::post('visitor/delete/{id}', ['as' => 'staff/visitor/delete/{id}', 'uses' => RosterController::class.'@postVisitorDelete']);

            Route::group(['before' => 'executive', 'prefix' => 'teamspeak'], function() {
                Route::get('/', ['as' => 'teamspeak.index', 'uses' => TeamspeakController::class.'@getIndex']);
                Route::post('kick/{cid}', ['as' => 'teamspeak.kick', 'uses' => TeamspeakController::class.'@postKick']);
                Route::post('message/{cid}', ['as' => 'teamspeak.message', 'uses' => TeamspeakController::class.'@postMessage']);
            });
        }
      );

  }
);

Route::group(['before' => 'facilities'], function() {
    Route::get('/staff/files', ['as' => 'staff.files', 'uses' => AdminController::class.'@getFacilityFiles']);
    Route::post('/staff/files', ['as' => 'staff.files.upload', 'uses' => AdminController::class.'@postUploadFiles']);
    Route::get('/staff/files/delete/{name}', ['as' => 'staff.files.delete', 'uses' => AdminController::class.'@getDeleteFile']);
});



Route::get('/staff/feedback', ['as' => 'staff/feedback', 'before' => 'feedback', 'uses' => FeedbackController::class.'@viewFeedback']);
Route::get('/staff/feedback/delete/{id}', ['as' => 'staff.feedback.delete', 'before' => 'feedback', 'uses' => FeedbackController::class.'@deleteFeedback']);

Route::group(['before' => 'instructor'], function () {
      //TODO create routes
  }
);

Route::group(['before' => 'mentor'], function () {
      Route::get('staff/training/{id}', TrainingController::class.'@showAdmin');
  }
);
Route::post('/staff/poker/{id}', ['as' => '/staff/poker/{id}', 'uses' => PokerController::class.'@postDiscard']);
Route::post('{id}/edit', ['as' => 'roster/user/{id}/edit', 'uses' => RosterController::class.'@postEditUser']);
