<?php

namespace app\controllers;

use app\component\Constants;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class BaseController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'metadata', 'acs'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (in_array($action->id, ['accessdenied', 'data', 'logout', 'error','dashboard-detail']))
                                return true;
                            $name = implode("-", [$action->controller->id, $action->id]);
                            if (Yii::$app->user->identity->user_type == Constants::USERTYPE_ADMIN) {
                                return true;
                            }
                            return Yii::$app->user->can($name);
                        }
                    ],
                ],
                'denyCallback' => function () {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->response->redirect(['site/login']);
                    } else {
                        if (Yii::$app->user->identity->user_type == Constants::USERTYPE_ADMIN) {
                            return true;
                        } else {
                            return Yii::$app->response->redirect(['site/accessdenied']);
                        }
                    }
                }
            ],
        ];
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            //$this->layout = 'yourNewLayout';
            return $this->render('error', ['exception' => $exception]);
        }
    }


}
