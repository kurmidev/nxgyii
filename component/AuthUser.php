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
        $children = $auth->getChildren($designation_id);
        $children = !empty($children) ? array_keys($children) : [];
        self::addAccessRights($designation_id, $items);
        foreach ($items as $item) {
            $cp = $auth->getPermission($item);
            if (!empty($cp)) {
                if (!in_array($item, $children)) {
                    $auth->addChild($desig, $cp);
                } else {
                    Yii::$app->authManager->removeChild($desig, $cp);
                }
            }
        }
    }

    public static function assignDesignation($username, $designation_name, $prev_designation = "") {
        $auth = Yii::$app->authManager;
        if (!empty($prev_designation)) {
            $item = $auth->getRole($prev_designation);
            if ($item) {
                $auth->revoke($item, $username);
            }
        }
        $desg = $auth->getRole($designation_name);
        if (!empty($desg)) {
            $auth->assign($desg, $username);
        }
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
