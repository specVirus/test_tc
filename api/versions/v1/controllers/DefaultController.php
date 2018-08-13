<?php

namespace api\versions\v1\controllers;

use common\filters\RbacAccessFilter;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends ActiveController
{
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(), 
            [
                'rbac' => [
                    'class' => RbacAccessFilter::class
                ]
            ]
        );
    }

    public $modelClass = User::class;

}