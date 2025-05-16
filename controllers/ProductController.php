<?php

namespace app\controllers;

use app\models\ProductMaster;
use app\models\ProductMasterSearch;
use app\controllers\BaseController;
use app\models\Products;
use app\models\ProductsApiList;
use app\models\ProductsApiListSearch;
use app\models\ProductSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
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
        $model = new ProductMaster(["scenario" => ProductMaster::SCENARIO_CREATE]);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Product $model->name added successfully.");
            return $this->redirect(['product/product']);
        } else {
            if (!empty($model->errors)) {
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

    public function actionNewproduct()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('products', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddNewProduct()
    {
        $model = new Products(["scenario" => Products::SCENARIO_CREATE]);
        if ($model->load($this->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Product $model->name added successfully.");
            return $this->redirect(['product/newproduct']);
        }
        return $this->render('form-new-product', [
            'model' => $model,
        ]);
    }

    public function actionUpdateNewProduct($id)
    {
        $model = Products::findOne($id);
        if (!$model instanceof Products) {
            Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['product/product']);
        }

        $model->scenario = Products::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Product $model->name updated successfully.");
            return $this->redirect(['product/newproduct']);
        }

        return $this->render('form-new-product', [
            'model' => $model,
        ]);
    }

    public function actionApiList($id)
    {
        $searchModel = new ProductsApiListSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['product_id' => $id]);

        return $this->render('product-api-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "product_id" => $id
        ]);
    }

    public function actionAddNewApi($product_id)
    {
        $model = new ProductsApiList(["scenario" => ProductsApiList::SCENARIO_CREATE]);
        $model->product_id = $product_id;
        if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Product Api $model->api_name added successfully.");
            return $this->redirect(['product/api-list', 'id' => $product_id]);
        } else {
            if (!empty($model->errors)) {
                print_r($model->errors);
                exit;
            }
        }
        return $this->render('form-new-api', [
            'model' => $model,
        ]);
    }

    public function actionUpdateApi($product_id, $id)
    {
        $model = ProductsApiList::findOne(['id' => $id, 'product_id' => $product_id]);
        if (!$model instanceof ProductsApiList) {
            Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['product/api-list', 'id' => $product_id]);
        }
        $model->scenario = ProductsApiList::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Product Api $model->api_name updated successfully.");
            return $this->redirect(['product/api-list', 'id' => $product_id]);
        }

        return $this->render('form-new-api', [
            'model' => $model,
        ]);
    }

    public function actionApiFetchData($product_id, $id)
    {
        $model = ProductsApiList::findOne(['id' => $id, 'product_id' => $product_id]);
        if (!$model instanceof ProductsApiList) {
            Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['product/api-list', 'id' => $product_id]);
        }

        $collectionName = $model->collectionName;

        $fetchedAt = null;
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query())->from($collectionName)
                ->andWhere([">", 'fetched_at', date("YmdHi", strtotime("-5 minutes"))])
                ,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $data = $dataProvider->getModels();
        $columns = [];
        if (!empty($data[0])) {
            foreach ($data[0] as $key => $value) {
                if (!is_array($value) && !in_array($key, ['_id', 'id', "company_id", "fetched_at"])) {
                    $columns[] = "$key:text:" . ucwords($key);
                }
            }
        }


        return $this->render('collection-list', [
            'dataProvider' => $dataProvider,
            "columns" => $columns,
            "product_id" => $product_id,
            "title" => $model->api_name
        ]);

    }

}
