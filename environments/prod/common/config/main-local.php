<?php
return [
    'components' => [
        'rabbitmq'  => [
            'class' => \mikemadisonweb\rabbitmq\Configuration::class,
            'connections' => [
                'default' => [
                    'host' => 'rabbitmq',
                    'port' => '5672',
                    'user' => 'user',
                    'password' => 'password',
                    'vhost' => '/',
                    'keepalive' => true,
                    'heartbeat' => 10,
                    'connection_timeout' => 3,
                    'read_write_timeout' => 3,
                ],
            ],
//            'producers' => [
//                'import_data' => [
//                    'connection' => 'default',
//                    'exchange_options' => [
//                        'name' => 'import_data',
//                        'type' => 'direct',
//                    ],
//                ],
//            ],
//            'consumers' => [
//                'import_data' => [
//                    'connection' => 'default',
//                    'exchange_options' => [
//                        'name' => 'import_data', // Name of exchange to declare
//                        'type' => 'direct', // Type of exchange
//                    ],
//                    'queue_options' => [
//                        'name' => 'import_data', // Queue name which will be binded to the exchange adove
//                        'routing_keys' => ['import_data'], // Your custom options
//                        'durable' => true,
//                        'auto_delete' => false,
//                    ],
//                    // Or just '\path\to\ImportDataConsumer' in PHP 5.4
//                    'callback' => \path\to\ImportDataConsumer::class,
//                ],
//            ],
        ],
        'cache' => [
            'class' => \yii\redis\Cache::class,
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 0,
            ]
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'pgsql:host=postgres;dbname=yii2_iway_template',
            'username' => 'postgres',
            'password' => 'root',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
        ],
        'session' => [
            'class' => \yii\redis\Session::class,
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 1,
            ]
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
//    'controllerMap' => [
//            'rabbitmq-consumer' => \mikemadisonweb\rabbitmq\controllers\ConsumerController::class,
//            'rabbitmq-producer' => \mikemadisonweb\rabbitmq\controllers\ProducerController::class,
//        ],
];
