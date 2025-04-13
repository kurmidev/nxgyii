<?php

namespace app\controllers;

use app\models\TicketComments;
use app\models\Tickets;
use app\models\TicketsSearch;
use PHPUnit\Framework\Attributes\Ticket;
use Yii;
use yii\web\UploadedFile;


class ComplaintController extends BaseController{
    
    public function actionIndex()
    {
        $searchModel = new TicketsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->excludeSysDef();
        return $this->render('tickets', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddComplaint(){
        $model = new Tickets(['scenario' => Tickets::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Ticket $model->code added successfully.");
            return $this->redirect(['complaint/index', 'id' => $model->id]);
        }
        return $this->render('form-complaint', [
            'model' => $model,
        ]);
    }

    public function actionProcessComplaint($id){
        $model = Tickets::findOne($id);

        if (!$model instanceof Tickets) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['complaint/index']);
        }

        $repyModel = new TicketComments(['scenario' => TicketComments::SCENARIO_CREATE]);
        $repyModel->ticket_id = $model->id;
        if ($repyModel->load(Yii::$app->request->post()) && $repyModel->validate() ) {
            $repyModel->save();
            Yii::$app->getSession()->setFlash('s', "Ticket $model->code reply added successfully.");
            return $this->redirect(['complaint/index', 'id' => $model->id]);
        }else if(!empty($repyModel->errors)){
            print_r($repyModel->errors);
            exit;
        }

        return $this->render('process-complaint', [
            'model' => $model,
            'replyModel'=>$repyModel
        ]);
    }


    public function actionCloseComplaint($id){
        $model = Tickets::findOne($id);
        if (!$model instanceof Tickets) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['complaint/index']);
        }

        $model->scenario = Tickets::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Ticket $model->code closed successfully.");
            return $this->redirect(['complaint/index']);
        }

        return $this->render('process-complaint', [
            'model' => $model,
        ]);

    }
}