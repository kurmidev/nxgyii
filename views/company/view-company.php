<?php

use app\component\Constants as C;

echo $this->render('@app/views/layouts/_contentheader');

if ($type == C::JUMPCLOUD) {
    echo $this->render("jump_cloud", [
        'model' => $model,
        'counts' => $counts,
        'product_id'=>$product_id
    ]);
} else {
    echo $this->render("seceon", [
        'model' => $model,
        'counts' => $counts,
        'product_id'=>$product_id
    ]);
}


