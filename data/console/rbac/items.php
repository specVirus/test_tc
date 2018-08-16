<?php
return [
    'v1/default/index' => [
        'type' => 2,
    ],
    'site/logout' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'v1/default/index',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'site/logout',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
    ],
];
