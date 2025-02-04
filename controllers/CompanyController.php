<?php

namespace app\controllers;

use app\models\Company;
use app\models\CompanySearch;
use app\controllers\BaseController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends BaseController
{
    /**
     * Lists all Designation models.
     *
     * @return string
     */
    public function actionCompany()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->excludeSysDef();
        return $this->render('company', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Reason model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddCompany()
    {
        $model = new Company(['scenario' => Company::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Company $model->name added successfully.");
            return $this->redirect(['company', 'id' => $model->id]);
        }else if(!empty($model->errors)){
            echo "<pre>";
            print_r($model->errors);
            exit;
        }
        return $this->render('form-company', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reason model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateCompany($id)
    {
        $model = Company::findOne($id);

        if (!$model instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }

        $model->scenario = Company::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Company $model->name updated successfully.");
            return $this->redirect(['company/company']);
        }

        return $this->render('form-company', [
            'model' => $model,
        ]);
    }

}
