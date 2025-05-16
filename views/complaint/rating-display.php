<?php

use app\component\Constants;

?>
<div class="rating flex-end">
    <?php for ($i = 1; $i <= count(Constants::LABEL_RATING); $i++) { ?>
        <div class="rating-label <?= ($i <= $model->rating) ? 'checked' : '' ?>">
            <i class="ki-duotone ki-star fs-1"></i>
        </div>
    <?php } ?>
</div>