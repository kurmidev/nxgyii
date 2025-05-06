<?php

namespace app\controllers;

use app\models\Company;
use app\models\CompanySearch;
use app\controllers\BaseController;
use app\form\ProductCompanyForm;
use app\models\ProductCompanyMapping;
use app\models\Products;
use app\services\DashboardService;
use app\services\JumpCloudService;
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
        } else if (!empty($model->errors)) {
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

    public function actionViewCompany($id)
    {
        $model = Company::findOne($id);
        if (!$model instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }

        return $this->render('view-company', [
            'model' => $model,
        ]);
    }

    public function actionViewCompanyOld($id, $product_id)
    {
        $model = Company::findOne($id);
        if (!$model instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }

        $service = new DashboardService($product_id);
        $counts = $service->getDashboardCounts();

        return $this->render('view-company', [
            'model' => $model,
            'counts' => $counts,
            "type" => $service->getDashboardTypes(),
            "product_id" => $product_id
        ]);

    }

    public function actionDetailView($type, $tenant_id, $service)
    {
        $service = new DashboardService($service);
        if ($service instanceof DashboardService) {
            $req = [
                "type" => $type,
                "tenant_id" => base64_decode($tenant_id)
            ];
            $d = $service->getData($req);

            return $this->render('detail-view', [
                'type' => $type,
                'dataProvider' => $d['dataProvider'],
                "service" => $service,
                "title" => $d['title'],
                "columns" => $d['columns']
            ]);
        }
        throw new NotFoundHttpException('Invalid service');
    }

    public function actionMapProduct($id)
    {
        $company = Company::findOne($id);
        if (!$company instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }
        
        $productList = Products::find()->where(['id' => $company->getProduct_mappings()])->all();
        $model  = new ProductCompanyForm(["scenario"=>"create"]);
        $model->company_id = $company->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Company maping with products updated successfully.");
            return $this->redirect(['company/company']);
        }

        $productMap = ProductCompanyMapping::find()->where(['company_id' => $company->id])->all();
        if(!empty($productMap)){
          foreach($productMap as $product){
            $model->credentials[$product->product_id] = $product->credentials;
            $model->headers[$product->product_id] = $product->headers;
          }
        }
        
        return $this->render('map-product', [
            'company' => $company,
            "products" => $productList,
            "model" =>  $model
        ]);

    }


    public function actionAddComponent($id)
    {
        $company = Company::findOne($id);
        if (!$company instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }

    }

}
