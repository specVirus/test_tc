<?php

namespace console\controllers;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: serj0987
 * Date: 18.07.17
 * Time: 18:52
 */
class SampleDaemonController extends Controller
{
    public function actionIndex() 
    {
        sleep(200);
        file_get_contents('https://requestb.in/1j12ap61');

    }

}