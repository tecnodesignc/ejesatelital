<?php

return [
    'polls.polls' => [
        'fill' => 'polls::polls.fill survey',
        'all' => 'polls::polls.list all resource',
        'index' => 'polls::polls.list resource',
        'create' => 'polls::polls.create resource',
        'edit' => 'polls::polls.edit resource',
        'destroy' => 'polls::polls.destroy resource',
    ],
    'polls.questions' => [
        'index' => 'polls::questions.list resource',
        'create' => 'polls::questions.create resource',
        'edit' => 'polls::questions.edit resource',
        'destroy' => 'polls::questions.destroy resource',
    ],
    'polls.answers' => [
        'index' => 'polls::answers.list resource',
        'create' => 'polls::answers.create resource',
        'edit' => 'polls::answers.edit resource',
        'destroy' => 'polls::answers.destroy resource',
    ],

    'polls.results' => [
        'index' => 'polls::results.list resource',
        'create' => 'polls::results.create resource',
        'edit' => 'polls::results.edit resource',
        'destroy' => 'polls::results.destroy resource',
    ],
// append

];
