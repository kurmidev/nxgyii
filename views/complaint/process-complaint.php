<?php

use app\component\Constants;
use app\component\Utils;
use app\models\TicketComments;
?>
<div class="card">
    <div class="card-body">
        <div class="d-flex flex-column flex-xl-row p-7">
            <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                <div class="mb-0">
                    <div class="d-flex align-items-center mb-12">
                        <i class="ki-duotone ki-file-added fs-4qx text-success ms-n2 me-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h1 class="text-gray-800 fw-semibold"> <?= $model->subject ?></h1>
                            <div class="">
                                <!--begin::Label-->
                                <span class="fw-semibold text-muted me-6">Category: <a href="#"
                                        class="text-muted text-hover-primary"><?= $model->subCategory->name ?>(<?= $model->category->name ?>)</a></span>
                                <!--end::Label-->

                                <!--begin::Label-->
                                <span class="fw-semibold text-muted me-6">By: <a href="#"
                                        class="text-muted text-hover-primary"><?= $model->addedByUser->name ?></a></span>
                                <!--end::Label-->

                                <!--begin::Label-->
                                <span class="fw-semibold text-muted">Created: <span class="fw-bold text-gray-600 me-1">
                                        <?= Utils::timeAgo($model->added_on) ?>
                                        <span></span>
                                        <!--end::Label-->
                            </div>
                        </div>
                    </div>
                    <div class="mb-15">
                        <div class="mb-15 fs-5 fw-normal text-gray-800">
                            <div class="mb-10">
                                <?= $model->description ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($model->status !== Constants::CLOSED && !empty($replyModel)) { ?>
                        <div class="row mb-7">
                            <?= $this->render("form-complaint-reply", ["model" => $replyModel]) ?>
                        </div>
                    <?php } ?>
                    <?php if ($model->status !== Constants::CLOSED && empty($replyModel)) { ?>
                        <div class="row mb-7">
                            <?= $this->render("form-complaint-closed", ["model" => $model]) ?>
                        </div>
                    <?php } ?>
                    <?php if ($model->status == Constants::CLOSED && empty($model->rating)) { ?>
                        <div class="row mb-7">
                            <?= $this->render("form-complaint-rating", ["model" => $model]) ?>
                        </div>
                    <?php } ?>
                    <?php if ($model->status == Constants::CLOSED && !empty($model->rating)) { ?>
                        <div class="row mb-7">
                            <?= $this->render("rating-display", ["model" => $model]) ?>
                        </div>
                    <?php } ?>
                    <div class="mb-15">
                        <?php foreach ($model->complaintReply as $k => $v) { ?>
                            <?= $this->render("complaint-reply", [
                                "model" => $v,
                            ]) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>