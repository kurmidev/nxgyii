<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

use app\component\Constants as C;
use app\models\User;
use Yii;

class ConsoleController extends \yii\console\Controller {

    public $init_time;
    public $end_time;
    public $response;
    public $error_record;
    public $success_record;
    public $total_record;
    public $cron_name;

    public function init() {
        $this->initateSession(C::CONSOLE_ID);
        $this->init_time = date("Y-m-d H:i:s");
    }

    public function initateSession($id) {
        $user = User::findOne(['id' => $id]);
        if ($user instanceof User) {
            Yii::$app->set('user', new \yii\web\User([
                'identityClass' => 'app\models\User',
                'identity' => $user,
            ]));
            
        }
    }
}
