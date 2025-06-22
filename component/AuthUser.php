<?php

namespace app\component;

use app\models\UserAccessRight;
use Yii;

class AuthUser {

    /**
     * itemTable: the table for storing authorization items. Defaults to "auth_item".
     * 
     * itemChildTable: the table for storing authorization item hierarchy. Defaults to "auth_item_child".
     * 
     * assignmentTable: the table for storing authorization item assignments. Defaults to "auth_assignment".
     *
     * ruleTable: the table for storing rules. Defaults to "auth_rule".
     * 
     */
    public static function itemsList($role = []) {
        $menus = MenuHelper::$menu;
        $i = [];
        foreach ($menus as $menu) {
            foreach ($menu['items'] as $items) {
                foreach ($items as $item) {
                    if (!empty($item['controller']) && !empty($item['action'])) {
                        if (!empty($role)) {
                            if (!empty($item['apply_to']) && array_intersect($role, $item['apply_to'])) {
                                $i[] = $item['controller'] . "-" . $item['action'];
                            }
                        } else {
                            $i[] = $item['controller'] . "-" . $item['action'];
                        }
                    }
                }
            }
        }
        return $i;
    }

    public static function addDesignationAuthRule($designation_id, $items = [], $role = []) {
        $items = empty($items) ? self::itemsList($role) : $items;
        $auth = Yii::$app->authManager;
        $desig = $auth->getRole($designation_id);
        if (!$desig) {
            $desig = $auth->createRole($designation_id);
            $auth->add($desig);
        }
        
        $allchildren = $auth->getChildren($designation_id);
        foreach ($allchildren as $child) {
            $auth->removeChild($desig, $child);
        }

        foreach($items as $item) {
            $cp = $auth->getPermission($item);
            if (!empty($cp)) {
                $auth->addChild($desig, $cp);
            }
        }
    }

    public static function assignDesignation($username, $designation_name) {
        $auth = Yii::$app->authManager;
        $auth->revokeAll($username);
        $desig = $auth->getRole($designation_name);
        $auth->assign($desig,$username);
    }

    public static function addAccessRights($role_name, $items) {
        $model = UserAccessRight::findOne(['role_name' => $role_name]);
        if (!$model instanceof UserAccessRight) {
            $model = new UserAccessRight(['scenario' => UserAccessRight::SCENARIO_CREATE]);
            $model->role_name = $role_name;
        } else {
            $model->scenario = UserAccessRight::SCENARIO_UPDATE;
        }
        $model->items = $items;
        if ($model->validate() && $model->save()) {
            return true;
        }
        return false;
    }

}
