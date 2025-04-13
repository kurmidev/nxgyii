<?php

use app\component\Utils;
?>
<div class="mb-9">
        <!--begin::Card-->
        <div class="card card-bordered w-100">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Wrapper-->
                <div class="w-100 d-flex flex-stack mb-8">
                    <!--begin::Container-->
                    <div class="d-flex align-items-center f">
                        <!--begin::Author-->
                        <div class="symbol symbol-50px me-5">
                            <?=Utils::getInitialWithRandomColor($model->addedByUser->name)?>
                        </div>
                        <!--end::Author-->

                        <!--begin::Info-->
                        <div class="d-flex flex-column fw-semibold fs-5 text-gray-600 text-gray-900">
                            <!--begin::Text-->
                            <div class="d-flex align-items-center">
                                <!--begin::Username-->
                                <a href="/good/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary fs-5 me-3"><?=$model->addedByUser->name?></a>
                                <!--end::Username-->

                                <span class="m-0"></span>
                            </div>
                            <!--end::Text-->

                            <!--begin::Date-->
                            <span class="text-muted fw-semibold fs-6"><?=Utils::timeAgo($model->added_on)?></span>
                            <!--end::Date-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Desc-->
                <p class="fw-normal fs-5 text-gray-700 m-0">
                    <?=$model->comment?>
                </p>
                <!--end::Desc-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->

    </div>