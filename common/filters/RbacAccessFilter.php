<?php
/**
 * Created by PhpStorm.
 * User: serj0987
 * Date: 25.07.17
 * Time: 11:07
 */

namespace common\filters;


use common\helpers\Route;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class RbacAccessFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!\Yii::$app->user->can(Route::GetCurrentFullRoute())) {
            throw new ForbiddenHttpException('Access denied');
        }
        return true;
    }
    
}