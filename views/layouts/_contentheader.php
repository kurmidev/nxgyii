<?php

use app\component\MenuHelper;
use yii\helpers\Html;

$titleData = MenuHelper::renderPageTitle(Yii::$app->controller->id, Yii::$app->controller->action->id);
?>


<div class="row">
    <div class="col-sm-1">
        <i class="<?= !empty($titleData['icon']) ? $titleData['icon'] : "icon icon ion-ios-photos-outline" ?>"></i>
    </div>
    <div class="col-sm-6">
        <h4 class="text-uppercase"><?= !empty($titleData['title']) ? $titleData['title'] : "" ?></h4>
    </div>
    <div class="col-sm-5">
        <?php
        if (!empty($this->params['links'])) {
            $buttonGroup = [];
            foreach ($this->params['links'] as $key => $buttons) {
                $options = ['title' => $buttons['title'], "data-original-title" => $buttons['title'], "class" => "btn btn-teal pd-10"];
                if (!empty($buttons['options']))
                    $options = array_merge($options, $buttons['options']);
                $buttonGroup[] = Html::a(
                                Html::tag('i', "", ['class' => $buttons['class']]), $buttons['url'], $options
                );
            }
            echo Html::tag('div', implode(" ", $buttonGroup), ["class" => 'btn-group  pull-right', "role" => "group"]);
        }
        ?>
    </div>

</div><!-- d-flex -->

<?php if (Yii::$app->session->hasFlash('s')) { ?>
    <div class="alert alert-success">
        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
        <?= Yii::$app->session->getFlash('s'); ?>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('e')) { ?>
    <div class="alert alert-danger">
        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
        <?= Yii::$app->session->getFlash('e'); ?>
    </div>
<?php } ?>