<?php
/**
 * Created by PhpStorm.
 * User: serj0987
 * Date: 25.07.17
 * Time: 12:11
 */

namespace common\helpers;


class Route
{
    public static function GetCurrentFullRoute()
    {
        $parts = [];

        if (\Yii::$app->controller->module->id) {
            $parts[] = \Yii::$app->controller->module->id;
        }

        if (\Yii::$app->controller->id) {
            $parts[] = \Yii::$app->controller->id;
        }
        
        if (\Yii::$app->controller->action->id) {
            $parts[] = \Yii::$app->controller->action->id;
        }
        
        return implode('/', $parts);
    }

}