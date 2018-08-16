<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', __DIR__.'/../../');

require_once(__DIR__ .  '/../../vendor/autoload.php');
$loaders = spl_autoload_functions();
foreach ($loaders as &$loader) {
    if (is_array($loader) && ($loader[0] instanceof Composer\Autoload\ClassLoader)) {
        $loader[0]->setUseIncludePath(true);
    }
}

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'appDir' => YII_APP_BASE_PATH,
    'debug' => true,
    'excludePaths' => [
        YII_APP_BASE_PATH . '/vendor',
    ],
    'includePaths' => [YII_APP_BASE_PATH]
]);

$kernel->loadFile(YII_APP_BASE_PATH  . '/vendor/yiisoft/yii2/Yii.php');
$kernel->loadFile(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/base/UnknownClassException.php');
$kernel->loadFile(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/base/ErrorException.php');

require_once(__DIR__ .  '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');
