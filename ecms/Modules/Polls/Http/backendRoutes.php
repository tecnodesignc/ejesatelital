<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/polls'], function (Router $router) {
    $router->bind('questiontype', function ($id) {
        return app('Modules\Polls\Repositories\QuestionTypeRepository')->find($id);
    });
    $router->get('questiontypes', [
        'as' => 'admin.polls.questiontype.index',
        'uses' => 'QuestionTypeController@index',
        'middleware' => 'can:polls.questiontypes.index'
    ]);
    $router->get('questiontypes/create', [
        'as' => 'admin.polls.questiontype.create',
        'uses' => 'QuestionTypeController@create',
        'middleware' => 'can:polls.questiontypes.create'
    ]);
    $router->post('questiontypes', [
        'as' => 'admin.polls.questiontype.store',
        'uses' => 'QuestionTypeController@store',
        'middleware' => 'can:polls.questiontypes.create'
    ]);
    $router->get('questiontypes/{questiontype}/edit', [
        'as' => 'admin.polls.questiontype.edit',
        'uses' => 'QuestionTypeController@edit',
        'middleware' => 'can:polls.questiontypes.edit'
    ]);
    $router->put('questiontypes/{questiontype}', [
        'as' => 'admin.polls.questiontype.update',
        'uses' => 'QuestionTypeController@update',
        'middleware' => 'can:polls.questiontypes.edit'
    ]);
    $router->delete('questiontypes/{questiontype}', [
        'as' => 'admin.polls.questiontype.destroy',
        'uses' => 'QuestionTypeController@destroy',
        'middleware' => 'can:polls.questiontypes.destroy'
    ]);
    $router->bind('question', function ($id) {
        return app('Modules\Polls\Repositories\QuestionRepository')->find($id);
    });
    $router->get('questions', [
        'as' => 'admin.polls.question.index',
        'uses' => 'QuestionController@index',
        'middleware' => 'can:polls.questions.index'
    ]);
    $router->get('questions/create', [
        'as' => 'admin.polls.question.create',
        'uses' => 'QuestionController@create',
        'middleware' => 'can:polls.questions.create'
    ]);
    $router->post('questions', [
        'as' => 'admin.polls.question.store',
        'uses' => 'QuestionController@store',
        'middleware' => 'can:polls.questions.create'
    ]);
    $router->get('questions/{question}/edit', [
        'as' => 'admin.polls.question.edit',
        'uses' => 'QuestionController@edit',
        'middleware' => 'can:polls.questions.edit'
    ]);
    $router->put('questions/{question}', [
        'as' => 'admin.polls.question.update',
        'uses' => 'QuestionController@update',
        'middleware' => 'can:polls.questions.edit'
    ]);
    $router->delete('questions/{question}', [
        'as' => 'admin.polls.question.destroy',
        'uses' => 'QuestionController@destroy',
        'middleware' => 'can:polls.questions.destroy'
    ]);
    $router->bind('answer', function ($id) {
        return app('Modules\Polls\Repositories\AnswerRepository')->find($id);
    });
    $router->get('answers', [
        'as' => 'admin.polls.answer.index',
        'uses' => 'AnswerController@index',
        'middleware' => 'can:polls.answers.index'
    ]);
    $router->get('answers/create', [
        'as' => 'admin.polls.answer.create',
        'uses' => 'AnswerController@create',
        'middleware' => 'can:polls.answers.create'
    ]);
    $router->post('answers', [
        'as' => 'admin.polls.answer.store',
        'uses' => 'AnswerController@store',
        'middleware' => 'can:polls.answers.create'
    ]);
    $router->get('answers/{answer}/edit', [
        'as' => 'admin.polls.answer.edit',
        'uses' => 'AnswerController@edit',
        'middleware' => 'can:polls.answers.edit'
    ]);
    $router->put('answers/{answer}', [
        'as' => 'admin.polls.answer.update',
        'uses' => 'AnswerController@update',
        'middleware' => 'can:polls.answers.edit'
    ]);
    $router->delete('answers/{answer}', [
        'as' => 'admin.polls.answer.destroy',
        'uses' => 'AnswerController@destroy',
        'middleware' => 'can:polls.answers.destroy'
    ]);
// append



});
