<?php
namespace app\component;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\component\Constants as C;

class MenuHelper
{

    public static $menu = [
        "dashboard" => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-home"],
            "items" => [
                'dashboard' => [
                    ['module' => '', 'controller' => 'site', 'action' => 'index', 'label' => 'Dashboard', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'site', 'action' => 'changes-password', 'label' => 'Change Password', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"]
                ]
            ]
        ],
        'product' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-wrench"],
            "items" => [
                'product' => [
                    ['module' => '', 'controller' => 'product', 'action' => 'product', 'label' => 'product', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'product', 'action' => 'add-product', 'label' => 'Add product', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'product', 'action' => 'update-product', 'label' => 'Update product', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
            ]
        ],
        'designation' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-wrench"],
            "items" => [
                'designation' => [
                    ['module' => '', 'controller' => 'designation', 'action' => 'designation', 'label' => 'Designation', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'designation', 'action' => 'add-designation', 'label' => 'Add Designation', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'designation', 'action' => 'update-designation', 'label' => 'Update Designation', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
            ]
        ],
        'company' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-wrench"],
            "items" => [
                'company' => [
                    ['module' => '', 'controller' => 'company', 'action' => 'company', 'label' => 'company', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'company', 'action' => 'add-company', 'label' => 'Add company', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'company', 'action' => 'update-company', 'label' => 'Update company', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ],
            ]
        ],
        'employee' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-user-circle"],
            "items" => [
                "employee" => [
                    ['module' => '', 'controller' => 'employee', 'action' => 'employee', 'label' => 'Employee', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'employee', 'action' => 'add-employee', 'label' => 'Add Employee', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'employee', 'action' => 'update-employee', 'label' => 'Update Employee', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ]
            ]
        ],
        "CRM" => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa  fa-ticket"],
            "items" => [
                "complaint" => [
                    ['module' => '', 'controller' => 'complaint', 'action' => 'index', 'label' => 'Complaint', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'complaint', 'action' => 'add-complaint', 'label' => 'Add New Complaint', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'complaint', 'action' => 'process-complaint', 'label' => 'Process Ticket', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'complaint', 'action' => 'view-complaint', 'label' => 'Ticket Details', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ]
            ]
        ],
        'plugin' => [
            "config" => ["class" => "menu-item-icon icon tx-18 fa fa-wifi"],
            "items" => [
                'plugin' => [
                    ['module' => '', 'controller' => 'plugin', 'action' => 'index', 'label' => 'Plugin', 'is_menu' => true, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plugin', 'action' => 'add-sms', 'label' => 'SMS', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                    ['module' => '', 'controller' => 'plugin Gateway', 'action' => 'add-pg', 'label' => 'Payment Gateway', 'is_menu' => false, 'icon' => "icon icon ion-ios-photos-outline"],
                ]
            ]
        ],
    ];

    public static function getDisplayMenu($menu = [], $is_submenu = false)
    {
        $menu = empty($menu) ? self::$menu : $menu;
        $result = [];
        foreach ($menu as $key => $mvalues) {
            $menuItems = empty($mvalues['items']) ? $mvalues : $mvalues['items'];
            $menuConfig = empty($mvalues['config']) ? [] : $mvalues['config'];
            $is_submenu = count($menuItems) > 1 ? true : false;
            if (ArrayHelper::isAssociative($menuItems)) {
                foreach ($menuItems as $k => $m) {
                    if ($is_submenu) {
                        $label = self::styleMenuLabel($key, $menuConfig);
                        /*
                         <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                  <use xlink:href="/images/icons/free.svg#cil-puzzle"></use>
                </svg> Base</a>
              <ul class="nav-group-items compact">
                <li class="nav-item"><a class="nav-link" href="base/accordion.html"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> Accordion</a></li>
                <li class="nav-item"><a class="nav-link" href="base/breadcrumb.html"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> Breadcrumb</a></li>
                        </ul>
                        */

                        $result[$key] = [
                            'url' => "#",
                            'label' => $label,
                            'options' => ['class' => 'nav-group'],
                            'items' => array_values(self::getDisplayMenu($menuItems)),
                            'submenuTemplate' => "\n<ul class = 'nav-group-items compact '>\n{items}\n</ul>\n",
                            'template' => '<a href="{url}" class="nav-link nav-group-toggle">{label}</a>',
                        ];
                    } else {
                   /*     <li class="nav-item"><a class="nav-link" href="index.html">
                        <svg class="nav-icon">
                          <use xlink:href="/images/icons/free.svg#cil-speedometer"></use>
                        </svg> Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span>
                      </a>
                      </li>
                      */

                        $mv = current($m);
                        $label = self::styleMenuLabel($mv['label'], $menuConfig);
                        $result[$k] = [
                            'url' => Yii::$app->urlManager->createUrl(implode("/", [$mv['module'], $mv['controller'], $mv['action']])),
                            'label' => $label,
                            'options' => ['class' => 'nav-item'],
                            'template' => '<a href="{url}" class="nav-link" >{label}</a>',
                        ];
                    }
                }
            } else {
                foreach ($menuItems as $k => $mv) {
                    if ($mv['is_menu']) {
                        $result[$key] = [
                            'url' => Yii::$app->urlManager->createUrl(implode("/", [$mv['module'], $mv['controller'], $mv['action']])),
                            'label' => $mv['label'],
                            'template' => '<a href="{url}" class="sub-link">{label}</a>',
                            'options' => ['class' => "sub-item "],
                        ];
                    }
                }
            }
        }
        return $result;
    }

    public static function styleMenuLabel($label, $menuConfig = [])
    {
        $text = ucwords(implode(' ', preg_split('/(?=[A-Z])/', $label)));
        $label = "";
        if (!empty($menuConfig)) {
            $label .= Html::tag("i", "", ["class" => $menuConfig['class']]);
        }
        $label .='&nbsp&nbsp'. Html::tag('span', $text, ['class' => "menu-item-label"]);
        return $label;
    }

    public static function getDisplayTitle($menu = [])
    {
        $menu = empty($menu) ? self::$menu : $menu;
        $menuItem = !empty($menu['items']) ? $menu['items'] : $menu;
        $title = [];
        $st = [];
        foreach ($menuItem as $k => $m) {
            if (ArrayHelper::isAssociative($m)) {
                $st = self::getDisplayTitle($m);
            } else {
                foreach ($m as $sk => $sm) {
                    extract($sm);
                    $st[$controller][$action] = ['title' => $label, 'icon' => $icon];
                }
            }
            $title = ArrayHelper::merge($title, $st);
        }
        return $title;
    }

    public static function renderMenu()
    {
        return MenuHelper::getDisplayMenu();
        // return Yii::$app->cache->getOrSet('menu', function () {
        //             return MenuHelper::getDisplayMenu();
        //         });
    }

    public static function renderPageTitle($c = "", $a = "")
    {
        $titleList = \Yii::$app->cache->getOrSet('titles', function () {
            return MenuHelper::getDisplayTitle();
        });
        return !empty($titleList[$c][$a]) ? $titleList[$c][$a] : SITE_NAME;
    }

    public static function getNotification()
    {
        return '';
    }

    public static function getAccountSetting()
    {

        $user = Yii::$app->user->getIdentity();
        if (empty($user)) {
            Yii::$app->controller->redirect('site/logout');
        }

        $link = [
            'profile' => Html::a('<i class="icon ion-ios-person"></i>Profile', \Yii::$app->urlManager->createUrl('site/profile')),
            'password' => Html::a('<i class="icon ion-ios-gear"></i>Change Password', \Yii::$app->urlManager->createUrl('site/changes-password')),
            'logout' => Html::a('<i class="icon ion-power"></i>Sign Out', \Yii::$app->urlManager->createUrl('site/logout')),
        ];

        $label = Html::a(
            Html::tag("div", substr($user['name'], 0, 1), ["class" => "tx-center text-uppercase font-weight-bold font- text-white"]),
            '#',
            ["class" => "nav-link nav-link-profile bg-teal rounded-circle mg-10", "data-toggle" => "dropdown"]
        );

        $dropdown = Html::tag(
            'div',
            Html::tag(
                'div',
                Html::tag("h6", $user['name'], ["class" => "logged-fullname"]),
                ['class' => 'tx-center']
            ) .
            Html::tag("hr") .
            Html::ul($link, [
                "class" => "list-unstyled user-profile-nav",
                'item' => function ($item, $index) {
                    return Html::tag('li', $item);
                }
            ]),
            ['class' => "dropdown-menu dropdown-menu-header wd-250"]
        );

        return Html::tag('div', $label . $dropdown, ['class' => 'dropdown']);
    }

    public static function reArrangeMenu()
    {
        $menus = self::$menu;

        foreach ($menus as $headers => $items) {
            $res[$headers] = ["header" => $headers, "css" => $items['config']['class']];
            foreach ($items['items'] as $mainItem => $subitems) {
                $res[$headers]['items'][$mainItem] = ArrayHelper::getColumn($subitems, function ($m) {
                    return ['id' => $m['controller'] . "-" . $m['action'], 'label' => $m['label']];
                });
            }
        }
        return $res;
    }

}

