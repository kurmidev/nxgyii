<?php

use app\component\MenuHelper;
use yii\helpers\Html;

$titleData = MenuHelper::renderPageTitle(Yii::$app->controller->id, Yii::$app->controller->action->id);

?>

<div class="card-header align-items-center py-5 gap-2 gap-md-5">
    <div class="card-title">
        
    </div>
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <div class="d-flex justify-content-end">
            <?php
            if (!empty($this->params['links'])) {
                $buttonGroup = [];
                foreach ($this->params['links'] as $key => $buttons) {
                    $options = ['title' => $buttons['title'], "data-original-title" => $buttons['title'], "class" => "btn btn-primary float-lg-right pull-right"];
                    if (!empty($buttons['options']))
                        $options = array_merge($options, $buttons['options']);
                    $buttonGroup[] = Html::a(
                        $buttons["title"],
                        $buttons['url'],
                        $options
                    );
                }
                //echo Html::tag('div', implode(" ", $buttonGroup), ["class" => 'btn-group float-lg-right pull-right', "role" => "group"]);
                echo implode(" ", $buttonGroup);
            }
            ?>
        </div>
    </div>
    <!--end::Card toolbar-->
</div>


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