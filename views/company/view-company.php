<?php

use app\component\widgets\CountWidget;
use app\component\widgets\ListingWidget;
use app\component\widgets\PieChartWidget;
use app\component\widgets\SingleCardWidget;

?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<div id="kt_app_content_container" class="app-container  container-fluid ">
    <div class="py-5">
        <div class="d-flex rounded border p-5 p-lg-15 pb-lg-12 landing-dark-bg">
            <?= CountWidget::widget(["type" => "square", "title" => "Oganizations", "count" => $counts["organization"]]) ?>
            <?= CountWidget::widget(["type" => "square", "title" => "Users", "count" => $counts["total_user"]]) ?>
            <?= CountWidget::widget(["type" => "square", "title" => "Devices", "count" => $counts["total_device"]]) ?>
            <?= CountWidget::widget(["type" => "square", "title" => "Administrators", "count" => $counts["administer"]]) ?>
        </div>
    </div>
    <div class="py-5">
        <div class="d-flex rounded border p-5 p-lg-15 pb-lg-12 landing-dark-bg">
            <?= CountWidget::widget(["type" => "circle", "title" => "User Lockouts", "count" => $counts["lockouts"]]) ?>
            <?= CountWidget::widget(["type" => "circle", "title" => "Expired Passwords", "count" => $counts["password_expired"]]) ?>
            <?= CountWidget::widget(["type" => "circle", "title" => "Upcoming Password </br> Expirations", "count" => $counts["password_about_expiring"]]) ?>
            <?= CountWidget::widget(["type" => "circle", "title" => "New Users", "count" => $counts["new_user"]]) ?>
        </div>
    </div>
    <div class="py-5">
        <div class="d-flex rounded border p-5 p-lg-15 pb-lg-12 landing-dark-bg">
            <?= CountWidget::widget(["type" => "circle", "title" => "Scheduled User </br> Suspensions", "count" => $counts["suspended_user"]]) ?>
            <?= CountWidget::widget(["type" => "circle", "title" => "Scheduled User </br> Activations", "count" => $counts["scheduled_activation"]]) ?>
            <?= CountWidget::widget(["type" => "circle", "title" => "Reports Ready </br> For Download", "count" => $counts["reports_ready"]]) ?>
            <?= CountWidget::widget(["type" => "circle", "title" => " Admins Without </br> MFA Required", "count" => $counts["without_mfa"]]) ?>
        </div>
    </div>
    <div class="py-5">
        <?= PieChartWidget::widget(["title" => "Certificate and Token Status Board", "data" => $counts["certificates"]["data"], "viewObj" => $this, "listData" => $counts["certificates"]["list"]]) ?>
    </div>
    <div class="py-5">
        <div class="d-flex rounded border p-5 p-lg-15 pb-lg-12 landing-dark-bg">
            <?= ListingWidget::widget(["title" => "User Notifications", "listData" => $counts["user_notification"]]) ?>
            <?= ListingWidget::widget(["title" => "Device Notifications", "listData" => $counts["device_notifications"]]) ?>
            <?= ListingWidget::widget(["title" => "Recent OS Releases (past 14 days)", "listData" => $counts["release_trains"]]) ?>
        </div>
    </div>

</div>