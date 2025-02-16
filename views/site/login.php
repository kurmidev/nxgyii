<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

        <!--begin::Form-->
        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                "options"=>['class'=>"form w-100 fv-plugins-bootstrap5 fv-plugins-framework","id"=>"kt_sign_in_form"],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

              <!--begin::Heading-->
              <div class="text-center mb-10">
                <!--begin::Title-->
                <h1 class="text-gray-900 mb-3">
                  Sign In to NXG Portal </h1>
                <!--end::Title-->
              </div>
              <!--begin::Heading-->

              <!--begin::Input group-->
              <div class="fv-row mb-10 fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="form-label fs-6 fw-bold text-gray-900">Email</label>
                <!--end::Label-->

                <!--begin::Input-->
                <?= $form->field($model, 'username')->textInput(['autofocus' => true,"class"=>"form-control form-control-lg form-control-solid"])->label(false) ?>
                <!--end::Input-->
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="fv-row mb-10 fv-plugins-icon-container">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-2">
                  <!--begin::Label-->
                  <label class="form-label fw-bold text-gray-900 fs-6 mb-0">Password</label>
                  <!--end::Label-->

                  <!--begin::Link-->
                  <a href="/good/authentication/sign-in/password-reset.html" class="link-primary fs-6 fw-bold">
                    Forgot Password ?
                  </a>
                  <!--end::Link-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Input-->

                  <?= $form->field($model, 'password')->passwordInput(["class"=>"form-control form-control-lg form-control-solid","autocomplete"=>"off"])->label(false) ?>
                <!--end::Input-->
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
              <!--end::Input group-->

              <!--begin::Actions-->
              <div class="text-center">
                <!--begin::Submit button-->
                <?= Html::submitButton('<span class="indicator-label">Continue</span>', ['class' => 'btn btn-lg btn-primary w-100 mb-5', 'name' => 'login-button',"id"=>"kt_sign_in_submit"]) ?>
                <!--end::Submit button-->

                <!--begin::Separator-->
                <div class="text-center text-muted text-uppercase fw-bold mb-5">or</div>
                <!--end::Separator-->

                <!--begin::Google link-->
                <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                  <img alt="Logo" src="/media/svg/brand-logos/google-icon.svg" class="h-20px me-3">
                  Continue with Google
                </a>
                <!--end::Google link-->

                <!--begin::Google link-->
                <a href="<?= Yii::$app->urlManager->createUrl('saml/login') ?>" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                  <img alt="Logo" src="/media/svg/brand-logos/microsoft-azure.svg" class="h-20px me-3">
                  Continue with Azure
                </a>
                <!--end::Google link-->
              </div>
              <!--end::Actions-->
            </form>
            <!--end::Form-->
<?php ActiveForm::end(); ?>