<div id="kt_app_content_container" class="app-container  container-fluid ">

    <div class="card mb-5 mb-xxl-8">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <div class="flex-grow-1">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <div class="d-flex flex-wrap">


                                <div class="border border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fs-1 fw-bold counted">0</div>
                                    <div class="fw-semibold fs-6 text-gray-500">Organization</div>
                                </div>


                                <div class="border border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fs-1 fw-bold counted"><?=$user["user_totals"]?></div>
                                    <div class="fw-semibold fs-6 text-gray-500">Users</div>
                                </div>


                                <div class="border border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fs-1 fw-bold counted">0</div>
                                    <div class="fw-semibold fs-6 text-gray-500"> Devices</div>
                                </div>


                                <div class="border border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="fs-1 fw-bold counted"><?=count($user["administrative_user"])?></div>
                                    <div class="fw-semibold fs-6 text-gray-500">Administrators</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>