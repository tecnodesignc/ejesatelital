<?php

return [
    'polls.questiontypes' => [
        'index' => 'polls::questiontypes.list resource',
        'create' => 'polls::questiontypes.create resource',
        'edit' => 'polls::questiontypes.edit resource',
        'destroy' => 'polls::questiontypes.destroy resource',
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
// append



];
