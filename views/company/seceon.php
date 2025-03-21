<?php

use app\component\widgets\CountWidget;
use app\models\seceon\SeceonTenantModel;
use app\component\Utils as U;
use app\component\widgets\ListingWidget;

$tenants = SeceonTenantModel::find()->indexBy('tenant_id')->asArray()->all();

?>
<div id="kt_app_content_container" class="app-container  container-fluid ">

    <div class="row gx-5 gx-xl-10">
        <?php foreach ($counts["data"] as $count) { ?>
            <div class="col-sm-6 mb-5 mb-xl-10">
                <div class="card card-flush h-lg-100">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">
                                <?= $tenants[$count["tenant_id"]]["tenant_name"] ?></span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="d-flex flex-stack">
                            <div class="text-gray-700 fw-semibold fs-6 me-2">
                                <a href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "events", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>"
                                    class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                                    Events
                                </a>

                            </div>
                            <div class="d-flex align-items-senter">
                                <span class="text-gray-900 fw-bolder fs-6"><?= U::prefixNumber($count["events"]) ?></span>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex flex-stack">
                            <div class="text-gray-700 fw-semibold fs-6 me-2">EPS</div>
                            <div class="d-flex align-items-senter">
                                <span class="text-gray-900 fw-bolder fs-6"><?= U::prefixNumber($count["max_eps"]) ?></span>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex flex-stack">
                            <div class="text-gray-700 fw-semibold fs-6 me-2">
                                <a href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "threats", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>"
                                    class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                                    Threats
                                </a>
                            </div>
                            <div class="d-flex align-items-senter">
                                <span class="text-gray-900 fw-bolder fs-6"><?= U::prefixNumber($count["threats"]) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="rounded border p-10 pb-0 d-flex flex-wrap align-items-center">
                        <a href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "open", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>"
                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                            <span class="badge badge-circle badge-outline badge-warning border-2 me-10 mb-10" title="Open">
                                <?= $count["assigned"] ?>
                            </span>
                        </a>
                        <a href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "closed", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>"
                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                            <span class="badge badge-circle badge-outline badge-success border-2 me-10 mb-10"
                                title="Closed">
                                <?= $count["closed"] ?>
                            </span>
                        </a>
                        <a href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "remediated", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>"
                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                            <span class="badge badge-circle badge-outline badge-dark border-2 me-10 mb-10"
                                title="Remediated">
                                <?= $count["remediated"] ?>
                            </span>
                        </a>
                    </div>
                    <ul class="nav nav-pills nav-pills-custom mb-3 mt-3 mx-6">
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link btn btn-outline btn-flex btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 
                        active" id="kt_charts_widget_10_tab_1" title="Minor"
                                href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "minor", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>">
                                <div class="nav-icon mb-3">
                                    <i class="ki-duotone ki-shield-cross fs-1 p-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">
                                        <?= $count["minor"] ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link btn btn-outline btn-flex btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 
                        active" id="kt_charts_widget_10_tab_1" title="Major"
                                href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "major", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>">
                                <div class="nav-icon mb-3">
                                    <i class="ki-duotone ki-security-user fs-1 p-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">
                                        <?= $count["major"] ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link btn btn-outline btn-flex btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 
                        active" title="System"
                                href="<?= Yii::$app->urlManager->createUrl(["/company/detail-view", "type" => "system", "tenant_id" => base64_encode($count["tenant_id"]), "service" => $product_id]) ?>"
                                id="kt_charts_widget_10_tab_1">
                                <div class="nav-icon mb-3">
                                    <i class="ki-duotone ki-screen fs-1 p-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">
                                        <?= $count["system"] ?>
                                    </span>
                                </div>
                            </a>
                        </li>
                </div>
            </div>
        <?php } ?>
    </div>
</div>