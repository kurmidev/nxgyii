<?php

use app\component\Constants;
use app\component\widgets\PieChartWidget;

$this->title = 'Dashoard';
$this->params['links'] = [
];
$this->params['breadcrumbs'][] = "Dashoard";

$globalComplaintView = [];
if (!empty($complaint["generalWise"])) {
    foreach (Constants::LABEL_COMPLAINT_STATUS as $key => $value) {
        $globalComplaintView[] = [
            "label" => $value,
            "count" => !empty($complaint["generalWise"][$value]) ? $complaint["generalWise"][$value] : 0
        ];
    }
}

$globalCompanyWiseView = [];
if (!empty($complaint["compayWise"])) {
    foreach ($complaint["compayWise"] as $key => $value) {
        $globalCompanyWiseView[] = [
            "label" => $key,
            "count" => (!empty($value[Constants::LABEL_COMPLAINT_STATUS[Constants::OPEN]]) ? $value[Constants::LABEL_COMPLAINT_STATUS[Constants::OPEN]] : 0) +
                (!empty($value[Constants::LABEL_COMPLAINT_STATUS[Constants::ON_HOLD]]) ? $value[Constants::LABEL_COMPLAINT_STATUS[Constants::ON_HOLD]] : 0)
        ];
    }
}
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<div id="kt_app_content_container" class="app-container  container-fluid ">
    <div class="row g-5 g-xxl-10">
        <div class="col-xl-5 col-xxl-5 mb-xl-5 mb-xxl-10">
            <?= PieChartWidget::widget([
                "title" => "Complaint Dashboard",
                "data" => $globalComplaintView,
                "viewObj" => $this,
                "listData" => []
            ]) ?>
        </div>
        <div class="col-xl-7 col-xxl-7  mb-5 mb-xxl-10">
            <?= PieChartWidget::widget([
                "title" => "CompanyWise Dashboard",
                "data" => $globalCompanyWiseView,
                "viewObj" => $this,
                "listData" => $complaint["compayWise"]
            ]) ?>
        </div>
    </div>
</div>