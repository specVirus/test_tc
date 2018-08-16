<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => \api\versions\v1\Module::class,
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => \common\models\User::class,
            'loginUrl' => null,
            'enableSession' => false
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'class' => \api\components\ErrorHandler::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => 'v1/default',
//					'extraPatterns' => [
//						'GET custom' => 'custom',
//						'GET protected' => 'protected',
//					],
                ],
            ],
        ],
        'authManager' => [
            'class' => \yii\rbac\PhpManager::class,
            'itemFile' => '@console/rbac/items.php',
            'assignmentFile' => '@console/rbac/assigments.php',
            'ruleFile' => '@console/rbac/rules.php',
            'defaultRoles' => ['guest'],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => \yii\web\Response::class,
            'on beforeSend' => function (\yii\base\Event $event) {
                /** @var \yii\web\Response $response */
                $response = $event->sender;
                if (empty(Yii::$app->controller)) {
                    $contentNeg = new \yii\filters\ContentNegotiator();
                    $contentNeg->response = $response;
                    $contentNeg->formats = Yii::$app->params['formats'];
                    $contentNeg->negotiate();
                }
                if (!isset($response->data['error'])) {
                    $response->data = [
                        'result' => $response->data,
                        'error' => null,
                    ];
                    $response->statusCode = 200;
                }

            },
        ],
    ],
    'params' => $params,
];
