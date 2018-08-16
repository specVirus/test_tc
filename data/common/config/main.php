<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1,
            'targets' => [
                'graylog' => [
                    'class' => \nex\graylog\GraylogTarget::class,
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'host' => 'graylog',
                ]
            ],
        ],
    ]
];
