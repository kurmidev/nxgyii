<?php

use app\component\MenuHelper;
use app\models\User;
use yii\helpers\ArrayHelper;
?>
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
  data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
  data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
  <!--begin::Logo-->
  <div class="app-sidebar-logo d-none d-lg-flex flex-stack flex-shrink-0 px-8" id="kt_app_sidebar_logo">
    <!--begin::Logo image-->
    <a href="/good/index.html">
      <img alt="Logo" src="/media/logos/default.png" class="theme-light-show h-50px">
      <img alt="Logo" src="/media/logos/default.png" class="theme-dark-show h-50px">
    </a>
    <!--end::Logo image-->

    <!--begin::Menu wrapper-->
    <!--end::Menu wrapper-->
  </div>
  <!--end::Logo-->

  <div class="separator d-none d-lg-block"></div>
  <!--begin::Sidebar menu-->
  <div class="app-sidebar-menu  hover-scroll-y my-5 my-lg-5 mx-3" id="kt_app_sidebar_menu_wrapper" data-kt-scroll="true"
    data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_toolbar, #kt_app_sidebar_footer"
    data-kt-scroll-offset="0" style="height: 868px;">


    <!--begin::Menu-->
    <div class="
            menu 
            menu-column 
            menu-sub-indention 
            menu-active-bg 
            fw-semibold" id="#kt_sidebar_menu" data-kt-menu="true">
      <?php foreach (MenuHelper::$menu as $menu => $menuDetails) { ?>
        <?php if (count($menuDetails['items']) > 1) { ?>
          <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
            <!--begin:Menu link-->
            <span class="menu-link">
              <span class="menu-icon">
                <i class="ki-duotone ki-chart-pie-3 fs-2">
                  <span class="path1"></span>
                  <span class="path2"></span>
                  <span class="path3"></span>
                </i>
              </span>
              <span class="menu-title"><?= ucwords($menu) ?></span>
              <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->
            <!--begin:Menu sub-->
            <div class="menu-sub menu-sub-accordion">
              <?php foreach ($menuDetails['items'] as $k => $v) {
                foreach ($v as $itemsName => $itemsData) {
                  if ($itemsData['is_menu']) { ?>
                    <div class="menu-item">
                      <a class="menu-link"
                        href="<?= Yii::$app->urlManager->createUrl(implode("/", [$itemsData['module'], $itemsData['controller'], $itemsData['action']])) ?>">
                        <span class="menu-bullet">
                          <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title"><?= $itemsName ?></span>
                      </a>
                      <!--end:Menu link-->
                    </div>
                  <?php }
                }
              }
              ?>
            </div><!--end:Menu sub-->
          </div><!--end:Menu item--><!--begin:Menu item-->
        <?php } else {
          foreach ($menuDetails['items'] as $m => $val) {
            $itemsData = ArrayHelper::index($val, 'is_menu');
            $itemsData = $itemsData[1];
            ?>
            <div class="menu-item here show menu-accordion">
              <!--begin:Menu link-->
              <span class="menu-link">
                <span class="menu-icon">
                  <i class="ki-solid <?=$itemsData["icon"]?> text-danger fs-2x">
                  </i>
                </span>
                <span class="">
                  <a class="menu-link"
                    href="<?= Yii::$app->urlManager->createUrl(implode("/", [$itemsData['module'], $itemsData['controller'], $itemsData['action']])) ?>">
                    <?= ucwords($menu) ?>
                  </a>
                </span>
              </span>
            </div>
          <?php }
        }
      }
      ?>

    </div>
    <!--end::Menu-->
  </div>
  <!--end::Sidebar menu-->

  <!--begin::User-->
  <div class="app-sidebar-user d-flex flex-stack py-5 px-8">
    <!--begin::User avatar-->
    <div class="d-flex me-5">
      <!--begin::Menu wrapper-->
      <div class="me-5">
        <!--begin::Symbol-->
        <div class="symbol symbol-40px cursor-pointer" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
          data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">

          <img src="/media/avatars/300-1.jpg" alt="">
        </div>
        <!--end::Symbol-->

        <!--begin::User account menu-->
        <div
          class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
          data-kt-menu="true">
          <!--begin::Menu item-->
          <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
              <!--begin::Avatar-->
              <div class="symbol symbol-50px me-5">
                <img alt="Logo" src="/media/avatars/300-1.jpg">
              </div>
              <!--end::Avatar-->

              <!--begin::Username-->
              <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">
                  <?=User::loggedInUserName()?> <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                </div>
              </div>
              <!--end::Username-->
            </div>
          </div>
          <!--end::Menu item-->

         
       

          <!--begin::Menu separator-->
          <div class="separator my-2"></div>
          <!--end::Menu separator-->

          <!--begin::Menu item-->
          <div class="menu-item px-5 my-1">
            <a href="<?=Yii::$app->urlManager->createUrl("site/profile")?>" class="menu-link px-5">
              Account Settings
            </a>
          </div>
          <!--end::Menu item-->

          <!--begin::Menu item-->
          <div class="menu-item px-5">
            <a href="<?=Yii::$app->urlManager->createUrl("site/logout")?>" class="menu-link px-5">
              Sign Out
            </a>
          </div>
          <!--end::Menu item-->
        </div>
        <!--end::User account menu-->

      </div>
      <!--end::Menu wrapper-->

      <!--begin::Info-->
      <div class="me-2">
        <!--begin::Username-->
        <a href="#" class="app-sidebar-username text-gray-800 text-hover-primary fs-6 fw-semibold lh-0"><?=User::loggedInUserName()?></a>
        <!--end::Username-->
      </div>
      <!--end::Info-->
    </div>
    <!--end::User avatar-->

    <!--begin::Action-->
    <a href="<?=Yii::$app->urlManager->createUrl("site/logout")?>"
      class="btn btn-icon btn-active-color-primary btn-icon-custom-color me-n4" data-bs-toggle="tooltip"
      aria-label="End session and singout" data-bs-original-title="End session and singout" data-kt-initialized="1">
      <i class="ki-duotone ki-entrance-left fs-2 text-gray-500"><span class="path1"></span><span
          class="path2"></span></i> </a>
    <!--end::Action-->
  </div>
  <!--end::User-->
</div>