<?php

namespace app\controllers;

use app\models\Employee;
use app\models\EmployeeSearch;
use app\controllers\BaseController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends BaseController
{
   
    /**
     * Lists all Employee models.
     *
     * @return string
     */
    public function actionEmployee()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAddEmployee()
    {
        $model = new Employee(["scenario"=>Employee::SCENARIO_CREATE]);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {  
            Yii::$app->getSession()->setFlash('s', "Employee $model->name added successfully.");
            return $this->redirect(['employee/employee']);
        } 
        return $this->render('form-employee', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateEmployee($id)
    {
        $model = Employee::findOne($id);

        if (!$model instanceof Employee) {
            Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['employee/employee']);
        }

        $model->scenario = Employee::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Employee $model->name updated successfully.");
            return $this->redirect(['employee/employee']);
        }
        
        return $this->render('form-employee', [
            'model' => $model,
        ]);
    }

}
