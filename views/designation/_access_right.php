<?php

use yii\helpers\Html;;
use app\component\Utils as U;

$card = "";
foreach ($menu as $header => $md) {

    $subCard = [];
    $sublist = [];

    foreach ($md['items'] as $subHeader => $items) {
        
        foreach ($items as $item) {
            $diableAll =  false;
            $ischeck = in_array($item['id'],$savedMenu);
            $subcheckbox = Html::checkbox("Designation[menu][" . $item['id'] . "]", $ischeck, ['name' => 'menu[' . $item['id'] . ']',
                        'id' => 'menu_' . $item['id'], 'class' => "menu_" . $item['id'], 'disabled' => $diableAll,'style'=>"opacity:1"]);
            $sublist[] = Html::tag('div', '<label class="ckbox">' . $subcheckbox . $item['label'] . '</label>', ['class' => 'ckbox']);
        }

        if (count($items) > 2) {
            $subCardBodyData = Html::ul($sublist, ['class' => 'list-group list-unstyled', 'encode' => FALSE, 'itemOptions' => ['class' => 'list-group-item']]);
            $subCardBody = Html::tag('div', $subCardBodyData, ['class' => 'card-body']);
            $subCardHeader = Html::tag('div', U::formatHeader($subHeader), ['class' => "card-header tx-medium"]);
            $subCard[] = Html::tag("div", $subCardHeader . $subCardBody, ["class" => "card col-3 col-md-3 col-sm-6 col-xs-12 m-2 p-0"]);
            $sublist = [];
        }
    }

    if (count($sublist) > 0) {
        $subbatch = array_chunk($sublist, 3);
        foreach ($subbatch as $sb) {
            $subCardBodyData = Html::ul($sb, ['class' => 'list-group list-unstyled', 'encode' => FALSE, 'itemOptions' => ['class' => 'list-group-item']]);
            $subCardBody = Html::tag('div', $subCardBodyData, ['class' => 'card-body']);
            $subCard[] = Html::tag("div", $subCardBody, ["class" => "card col-3 col-md-3 col-sm-6 col-xs-12 m-2 p-0 bd-0"]);
        }
        unset($sublist);
    }

    $cardBody = Html::tag('div', implode("", $subCard), ['class' => 'card-body row']);
    $cardHeader = Html::tag('div', U::formatHeader($header), ['class' => "card-header tx-medium"]);
    $card .= Html::tag("div", $cardHeader . $cardBody, ["class" => "card bd-1 m-2"]);
}
echo Html::tag("div", $card, ["class" => "m-10"]);

$js = ' $(".enchbbx").click(function(){
            var c = $(this).attr("id");
         
            if($(this).is(":checked")){  
                $("."+c).removeAttr("disabled");
            }else{
                $("."+c).removeAttr("checked");
                $("."+c).attr("disabled","diabled");
            }
        });  ';

$this->registerJs($js);
?>