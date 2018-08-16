<?php
/**
 * Created by PhpStorm.
 * User: serj0987
 * Date: 26.07.17
 * Time: 9:48
 */

namespace api\components;

use Yii;
use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @inheridoc
     */
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();           
            // reset parameters of response to avoid interference with partially created response data
            // in case the error occurred while sending the response.
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $response->data['result'] = null;
        $response->data['error'] = $this->convertExceptionToArray($exception);
        
        $response->setStatusCode($exception->statusCode);
        $response->send();
    }

}