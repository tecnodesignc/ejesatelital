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
    $router->bind('poll', function ($id) {
        return app('Modules\Polls\Repositories\PollRepository')->find($id);
    });
    $router->get('polls', [
        'as' => 'admin.polls.poll.index',
        'uses' => 'PollController@index',
        'middleware' => 'can:polls.polls.index'
    ]);
    $router->get('polls/create', [
        'as' => 'admin.polls.poll.create',
        'uses' => 'PollController@create',
        'middleware' => 'can:polls.polls.create'
    ]);
    $router->post('polls', [
        'as' => 'admin.polls.poll.store',
        'uses' => 'PollController@store',
        'middleware' => 'can:polls.polls.create'
    ]);
    $router->get('polls/{poll}/edit', [
        'as' => 'admin.polls.poll.edit',
        'uses' => 'PollController@edit',
        'middleware' => 'can:polls.polls.edit'
    ]);
    $router->put('polls/{poll}', [
        'as' => 'admin.polls.poll.update',
        'uses' => 'PollController@update',
        'middleware' => 'can:polls.polls.edit'
    ]);
    $router->delete('polls/{poll}', [
        'as' => 'admin.polls.poll.destroy',
        'uses' => 'PollController@destroy',
        'middleware' => 'can:polls.polls.destroy'
    ]);
    $router->bind('result', function ($id) {
        return app('Modules\Polls\Repositories\ResultRepository')->find($id);
    });
    $router->get('results', [
        'as' => 'admin.polls.result.index',
        'uses' => 'ResultController@index',
        'middleware' => 'can:polls.results.index'
    ]);
    $router->get('results/create', [
        'as' => 'admin.polls.result.create',
        'uses' => 'ResultController@create',
        'middleware' => 'can:polls.results.create'
    ]);
    $router->post('results', [
        'as' => 'admin.polls.result.store',
        'uses' => 'ResultController@store',
        'middleware' => 'can:polls.results.create'
    ]);
    $router->get('results/{result}/edit', [
        'as' => 'admin.polls.result.edit',
        'uses' => 'ResultController@edit',
        'middleware' => 'can:polls.results.edit'
    ]);
    $router->put('results/{result}', [
        'as' => 'admin.polls.result.update',
        'uses' => 'ResultController@update',
        'middleware' => 'can:polls.results.edit'
    ]);
    $router->delete('results/{result}', [
        'as' => 'admin.polls.result.destroy',
        'uses' => 'ResultController@destroy',
        'middleware' => 'can:polls.results.destroy'
    ]);
// append





});
