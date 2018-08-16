<?php
/**
 * Created by PhpStorm.
 * User: serj0987
 * Date: 25.07.17
 * Time: 10:40
 */

namespace console\controllers;

use yii\console\Controller;
use common\rbac\UserGroupRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;

        $guest  = $authManager->createRole('guest');
        $user  = $authManager->createRole('user');
        $admin  = $authManager->createRole('admin');

        $defaultIndex  = $authManager->createPermission('v1/default/index');
        $siteLogout  = $authManager->createPermission('site/logout');

        $authManager->add($defaultIndex);
        $authManager->add($siteLogout);

        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        $guest->ruleName  = $userGroupRule->name;
        $user->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;

        $authManager->add($guest);
        $authManager->add($user);
        $authManager->add($admin);

        $authManager->addChild($guest, $defaultIndex);
        $authManager->addChild($user, $siteLogout);
    }
}