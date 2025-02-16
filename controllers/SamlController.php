<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Error;

class SamlController extends BaseController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    private function getSAMLAuth()
    {
        $samlConfig = require Yii::getAlias('@app/config/saml.php');
        return new Auth($samlConfig);
    }

    // SSO Login
    public function actionLogin()
    {
        $auth = $this->getSAMLAuth();
        $auth->login();
    }

    // Handle SAML Response (ACS)
    public function actionAcs()
    {
        $auth = $this->getSAMLAuth();
        $auth->processResponse();

        if ($errors = $auth->getErrors()) {
            Yii::error('SAML Errors: ' . implode(', ', $errors), __METHOD__);
            return $this->redirect(['/site/error']);
        }

        $attributes = $auth->getAttributes();
        $userEmail = $auth->getNameId();

        // Find or Create User
        $user = \app\models\User::findOne(['email' => $userEmail]);
        if (!$user) {
            $user = new \app\models\User([
                'email' => $userEmail,
                'username' => explode('@', $userEmail)[0],
                'password' => Yii::$app->security->generateRandomString(), // Dummy password
            ]);
            $user->save();
        }

        Yii::$app->user->login($user);
        return $this->redirect(['/site/index']);
    }

    // SSO Logout
    public function actionLogout()
    {
        $auth = $this->getSAMLAuth();
        $auth->logout();
    }
}
