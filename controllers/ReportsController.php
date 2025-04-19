<?php

namespace app\controllers;

use app\models\TicketsSearch;
use app\models\User;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class ReportsController extends BaseController
{


    public function actionComplaint()
    {
        $searchModel = new TicketsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;
        return $this->render('complaint', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "title" => "Complaint",
            "search" => $searchModel->advanceSearch()
        ]);
    }

    public function actionEnggPerformance()
    {
        $searchModel = new TicketsSearch();
        $ticketObj = $searchModel->search(Yii::$app->request->queryParams);

        $ticketStats = $ticketObj->query->select([
            'assign_to',
            'total_tickets' => 'COUNT(*)',
            'resolved_tickets' => 'SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END)',
            'avg_rating' => 'AVG(rating)',
            'avg_resolution_time' => 'AVG(DATEDIFF(end_date, start_date))'
        ])
            ->where(['IS NOT', 'assign_to', null])
            ->groupBy('assign_to')
            ->asArray()
            ->all();

        // Get comment-based stats
        $commentStats = (new \yii\db\Query())
            ->select([
                'added_by',
                'total_comments' => 'COUNT(*)'
            ])
            ->from('ticket_comments')
            ->where(['IS NOT', 'added_by', null])
            ->groupBy('added_by')
            ->all();

        // Convert comment stats into key-value array
        $commentStatsIndexed = ArrayHelper::index($commentStats, 'added_by');
        // Combine the two
        $report = [];
        foreach ($ticketStats as $stat) {
            $engineerId = !empty($stat['assign_to'])? $stat['assign_to'] : 0;
            $report[] = [
                'engineer_id' => $engineerId,
                'engineer_name' => User::findOne($engineerId)->name ?? 'Unknown',
                'total_tickets' => $stat['total_tickets'],
                'resolved_tickets' => $stat['resolved_tickets'],
                'avg_rating' => round($stat['avg_rating'], 2),
                'avg_resolution_time_days' => round($stat['avg_resolution_time'], 2),
                'total_comments' => $commentStatsIndexed[$engineerId]['total_comments'] ?? 0,
            ];
        }

        $dataProvider = new  ArrayDataProvider([
            'allModels' => $report,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'attributes' => ['engineer_id', 'engineer_name'],
            ],
        ]);

        return $this->render('engg_performance', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "title" => "Complaint",
            "search" => $searchModel->advanceSearch()
        ]);

    }
}