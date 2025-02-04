<?php

namespace app\controllers;

use app\component\MenuHelper;
use app\models\Designation;
use app\models\DesignationSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DesignationController implements the CRUD actions for Designation model.
 */
class DesignationController extends BaseController
{
    /**
     * Lists all Designation models.
     *
     * @return string
     */
    public function actionDesignation()
    {
        $searchModel = new DesignationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->query->excludeSysDef();
        return $this->render('designation', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Reason model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddDesignation()
    {
        $model = new Designation(['scenario' => Designation::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Designation $model->name added successfully.");
            return $this->redirect(['designation', 'id' => $model->id]);
        }
        $menus = MenuHelper::reArrangeMenu();
        return $this->render('form-designation', [
            'model' => $model,
            "menu" => $menus,
            "savedMenu"=>[]
        ]);
    }

    /**
     * Updates an existing Reason model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateDesignation($id)
    {
        $model = Designation::findOne($id);

        if (!$model instanceof Designation) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['designation/designation']);
        }

        $model->scenario = Designation::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Designation $model->name updated successfully.");
            return $this->redirect(['designation']);
        }

        $menus = MenuHelper::reArrangeMenu();
        $savedMenu = Yii::$app->authManager->getChildren($model->code);
        
        return $this->render('form-designation', [
            'model' => $model,
            'menu' => $menus,
            'savedMenu' => !empty($savedMenu) ? array_keys($savedMenu) : []
        ]);
    }

}
