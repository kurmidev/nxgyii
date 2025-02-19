<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;
use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Error;
use OneLogin\Saml2\Utils;

class SamlController extends BaseController
{
    public $enableCsrfValidation = false;
    public function actionLogin()
    {
        $auth = new Auth(require Yii::getAlias('@app/config/saml.php'));
        $auth->login();
    }

    public function actionAcs()
    {
        $auth = new Auth(require Yii::getAlias('@app/config/saml.php'));
        $auth->processResponse();

        if (!$auth->isAuthenticated()) {
            Yii::$app->session->setFlash('error', 'SAML Authentication Failed');
            return $this->redirect(['site/login']);
        }

        $attributes = $auth->getAttributes();
        $userEmail = $auth->getNameId();

        $user = User::findOne(['email' => $userEmail]);

        if($user instanceof User){
            Yii::$app->user->login($user);
            return $this->redirect(['site/index']);
        }else{
            Yii::$app->getSession()->setFlash('e', 'USer is not registered');
            return $this->redirect(['site/login']);
        }
        
    }

    public function actionMetadata()
    {
        $auth = new Auth(require Yii::getAlias('@app/config/saml.php'));
        $settings = $auth->getSettings();
        $metadata = $settings->getSPMetadata();
        header('Content-Type: text/xml');
        echo $metadata;
    }

    public function actionLogout()
    {
        $auth = new Auth(require Yii::getAlias('@app/config/saml.php'));
        $auth->logout();
    }
}
