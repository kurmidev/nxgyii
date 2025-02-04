<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

<div class="form-group first">
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
</div>
<div class="form-group last mb-4">
    <?= $form->field($model, 'password')->passwordInput() ?>
</div>

<div class="d-flex mb-5 align-items-center">
    <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
</div>

<?= Html::submitButton('Login', ['class' => 'btn btn-block btn-primary', 'name' => 'login-button']) ?>

<span class="d-block text-left my-4 text-muted">— or login with —</span>

<div class="social-login">
    <a href="#" class="facebook">
        <span class="icon-facebook mr-3"></span>
    </a>
    <a href="#" class="twitter">
        <span class="icon-twitter mr-3"></span>
    </a>
    <a href="#" class="google">
        <span class="icon-google mr-3"></span>
    </a>
</div>
<?php ActiveForm::end(); ?>