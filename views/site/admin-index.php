<?php

use app\component\Constants;
use app\component\widgets\PieChartWidget;
use PHPUnit\TextUI\Configuration\Constant;

$this->title = 'Dashoard';
$this->params['links'] = [
];
$this->params['breadcrumbs'][] = "Dashoard";

$this->registerCssFile('@web/css/dashboard.css'); // optional external stylesheet

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
        <div class="col-xl-12 col-xxl-12 mb-5 mb-xxl-10">
            <div class="dashboard-container">



                <div class="top-stats">
                    <div class="stat-box">
                        <h2><?= $complaint["generalWise"][Constants::LABEL_COMPLAINT_STATUS[Constants::OPEN]] ?></h2>
                        <p>Open Tickets</p>
                    </div>
                    <div class="stat-box">
                    <h2><?= !empty($complaint["generalWise"][Constants::LABEL_COMPLAINT_STATUS[Constants::ON_HOLD]])?
                        $complaint["generalWise"][Constants::LABEL_COMPLAINT_STATUS[Constants::ON_HOLD]]:0 ?></h2>
                        <p>On Hold Tickets</p>
                    </div>
                    <div class="stat-box">
                        <h2><?= !empty($complaint["generalWise"][Constants::LABEL_COMPLAINT_STATUS[Constants::CLOSED]])?
                        $complaint["generalWise"][Constants::LABEL_COMPLAINT_STATUS[Constants::CLOSED]]:0 ?></h2>
                        <p>Closed Tickets</p>
                    </div>
                    <div class="stat-box">
                        <h2>00:00 hrs</h2>
                        <p>Average Response Time</p>
                    </div>
                    <div class="stat-box">
                        <h2>00:00 hrs</h2>
                        <p>Average Resolution Time</p>
                    </div>
                    <div class="stat-box">
                        <h2>😊 0%</h2>
                        <p>Happiness Rating</p>
                    </div>
                </div>

                <div class="middle-section">
                    <div class="circle-chart">
                        <!-- Placeholder for circular chart -->
                        <div class="circle-placeholder"></div>
                        <ul class="channels">
                            <li>Email (0)</li>
                            <li>Phone (0)</li>
                            <li>Chat (0)</li>
                        </ul>
                    </div>

                    <div class="timing-stats">
                        <p>First Response Time: 00:00</p>
                        <p>Average Response Time: 00:00</p>
                        <p>Average Resolution Time: 00:00</p>
                    </div>

                    <div class="rating-bar">
                        <p>0% Good (0)</p>
                        <p>0% Okay (0)</p>
                        <p>0% Bad (0)</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>