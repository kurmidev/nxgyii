<?php

/** @var \yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <link rel="shortcut icon" href="/media/logos/favicon.ico" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> <!--end::Fonts-->
  <?php $this->head() ?>

</head>

<body id="kt_body" class="app-blank">
  <?php $this->beginBody() ?>
  <!--begin::Theme mode setup on page load-->
  <script>
    var defaultThemeMode = "light";
    var themeMode;

    if (document.documentElement) {
      if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
      } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
          themeMode = localStorage.getItem("data-bs-theme");
        } else {
          themeMode = defaultThemeMode;
        }
      }

      if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
      }

      document.documentElement.setAttribute("data-bs-theme", themeMode);
    }            
  </script>
  <!--end::Theme mode setup on page load-->

  <!--begin::Root-->
  <div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Aside-->
      <div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
          <!--begin::Header-->
          <div class="d-flex flex-row-fluid flex-center flex-column text-center p-5 p-lg-20">
            <!--begin::Logo-->
            <a href="/good/index.html" class="py-9 pt-lg-20">
              <img alt="Logo" src="/media/logos/default.png" class="h-35px h-lg-40px">
            </a>
            <!--end::Logo-->

            <!--begin::Title-->
            <h1 class="d-none d-lg-block fw-bold text-white fs-2qx pb-5 pb-md-10">
              Welcome to NXG Portal
            </h1>
            <!--end::Title-->

            <!--begin::Description-->
            <p class="d-none d-lg-block fw-semibold fs-2 text-white">
              Server Monitoring. Faster. Easier.
            </p>
            <!--end::Description-->
          </div>
          <!--end::Header-->

          <!--begin::Illustration-->
          <div
            class="d-none d-lg-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-200px min-h-lg-350px mb-20"
            style="background-image: url(/media/illustrations/sketchy-1/17.png)">
          </div>
          <!--end::Illustration-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--begin::Aside-->

      <!--begin::Body-->
      <div class="d-flex flex-column flex-lg-row-fluid py-10">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid">
          <!--begin::Wrapper-->
          <div class="w-lg-500px p-10 p-lg-15 mx-auto">

          <?= $content ?>
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Content-->

       
      </div>
      <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
  </div>
  <!--end::Root-->
  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
