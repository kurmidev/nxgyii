<?php

namespace app\commands;

use app\component\AuthUser;
use app\component\Constants;
use app\component\MenuHelper;
use app\models\Designation;
use app\models\User;
use yii\console\ExitCode;

class InitController extends ConsoleController
{

    public function init()
    {
        $this->initateSession(Constants::CONSOLE_ID);
        $this->init_time = date("Y-m-d H:i:s");
    }

    public function actionRefresh(){
        $this->addRules();
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo "Adding Default designations....." . PHP_EOL;
        $this->addDefaultDesignation();
        echo "Finish adding Default designations....." . PHP_EOL;

        echo "Adding Rules ....." . PHP_EOL;
        $this->addRules();
        echo "Finish adding Rules ....." . PHP_EOL;

        echo "Adding Default admin user....." . PHP_EOL;
        $this->addAdminUser();
        echo "Finish adding  Default admin user....." . PHP_EOL;
        return ExitCode::OK;
    }

    public function addDefaultDesignation()
    {
        $desig = [Constants::DESIGNATION_SADMIN => "SADMIN"];

        foreach ($desig as $ds => $dn) {
            $d = Designation::findOne(['id' => $ds]);
            if (!$d instanceof Designation) {
                $d = new Designation();
                $d->scenario = Designation::SCENARIO_CREATE;
                $d->name = $dn;
                $d->parent_id = 0;
                $d->status = Constants::STATUS_ACTIVE;
                if ($d->validate() && $d->save()) {
                    Designation::updateAll(['id' => $ds], ['id' => $d->id]);
                    $role = [];
                    if ($ds > 0) {
                        $role = [$ds];
                    }
                    AuthUser::addDesignationAuthRule($d->name, [], $role);
                    echo "Designation {$d->name} created...." . PHP_EOL;
                }
            }
        }
    }

    public function addRules()
    {
        $menus = MenuHelper::$menu;
        $auth = \Yii::$app->authManager;
        $auth->removeAll();
        $auth->removeAllAssignments();
        foreach ($menus as $menu) {
            if (!empty($menu['items'])) {
                foreach ($menu['items'] as $items) {
                    foreach ($items as $item) {
                        if (!empty($item['controller']) && !empty($item['action'])) {
                            $name = $item['controller'] . "-" . $item['action'];
                            $cp = $auth->createPermission($name);
                            $cp->description = $item['label'];
                            echo $item['label'] . "----$name permission created" . PHP_EOL;
                            $auth->add($cp);
                            unset($cp);
                        }
                    }
                }
            }
        }
    }

    public function addAdminUser()
    {
        $username = "sadmin";
        $password =  strtolower(str_replace([" ", "."], "", SITE_NAME)) . "@" . date("Ymd");
        $model = User::findOne(['username' => $username]);
        if (!$model instanceof User) {
            $model = new User(['scenario' => User::SCENARIO_CREATE]);
            $model->name = "sadmin";
            $model->username = "sadmin";
            $model->user_type = Constants::USERTYPE_ADMIN;
        } else {
            $model->scenario = User::SCENARIO_UPDATE;
        }
        $model->password = md5($password);
        $model->password_hash = \Yii::$app->security->generatePasswordHash($password);
        $model->auth_key = \Yii::$app->security->generateRandomString();
        $model->status = Constants::STATUS_ACTIVE;
        if ($model->validate() && $model->save()) {
            echo "username => {$username} and password is  {$password}".PHP_EOL;
            return true;
        }else{
            print_r($model->errors);
        }
        return false;
    }
}
