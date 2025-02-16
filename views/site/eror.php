<?php
use yii\helpers\Html;
?>
<div class="site-error">
    <?= Html::encode($exception->getMessage()) ?>
</div>