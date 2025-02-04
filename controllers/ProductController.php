<?php

namespace app\controllers;

use app\models\ProductMaster;
use app\models\ProductMasterSearch;
use app\controllers\BaseController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for ProductMaster model.
 */
class ProductController extends BaseController
{

    /**
     * Lists all ProductMaster models.
     *
     * @return string
     */
    public function actionProduct()
    {
        $searchModel = new ProductMasterSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    /**
     * Creates a new ProductMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAddProduct()
    {
        $model = new ProductMaster(["scenario"=>ProductMaster::SCENARIO_CREATE]);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Product $model->name added successfully.");
            return $this->redirect(['product/product']);
        } else{
            if(!empty($model->errors)){
                print_r($model->errors);
                exit;
            }  
        }
        return $this->render('form-product', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateProduct($id)
    {
        $model = ProductMaster::findOne($id);

        if (!$model instanceof ProductMaster) {
            Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['designation/designation']);
        }

        $model->scenario = ProductMaster::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Product $model->name updated successfully.");
            return $this->redirect(['product/product']);
        }
        
        return $this->render('form-product', [
            'model' => $model,
        ]);
    }
}
