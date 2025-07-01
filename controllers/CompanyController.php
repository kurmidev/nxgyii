<?php

namespace app\controllers;

use app\component\GraphRenderer;
use app\component\Utils;
use app\models\Company;
use app\models\CompanySearch;
use app\controllers\BaseController;
use app\form\ProductCompanyForm;
use app\models\ComponentModel;
use app\models\ProductCompanyMapping;
use app\models\Products;
use app\models\ProductsApiCompanyMapping;
use app\models\ProductsApiCompanyMappingSearch;
use app\models\ProductsApiList;
use app\services\DashboardService;
use app\form\ChangePasswordForm;
use app\models\User;
use Yii;
use yii\data\ArrayDataProvider;
use yii\mongodb\Query;
use yii\web\NotFoundHttpException;

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

    public function actionViewCompany($id, $dash = null, $employee_id = null)
    {
        $model = Company::findOne($id);
        if (!$model instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }

        $searchModel = new ProductsApiCompanyMappingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view-company', [
            'model' => $model,
            "dash" => $dash,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "graph" => (new GraphRenderer($model->id, $dash, $dash == 0 ? true : false, $employee_id))->render(),
        ]);
    }

    public function actionViewCompanyOld($id, $product_id)
    {
        $model = Company::findOne($id);
        if (!$model instanceof Company) {
            Yii::$app->getSession()->setFlash('e', 'No record found');
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
        $model = new ProductCompanyForm(["scenario" => "create"]);
        $model->company_id = $company->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Company maping with products updated successfully.");
            return $this->redirect(['company/company']);
        }

        $productMap = ProductCompanyMapping::find()->where(['company_id' => $company->id])->all();
        if (!empty($productMap)) {
            foreach ($productMap as $product) {
                $model->credentials[$product->product_id] = $product->credentials;
                $model->headers[$product->product_id] = $product->headers;
                $model->allowed_api[$product->product_id] = $product->allowed_api;
            }
        }

        return $this->render('map-product', [
            'company' => $company,
            "products" => $productList,
            "model" => $model
        ]);

    }

    public function actionGetApiData($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->layout = false;

        if (empty($id)) {
            return [];
        }
        $response = $this->getApiResponseData($id);
        return $response;
    }

    private function getApiResponseData($id)
    {

        $productApi = ProductsApiList::findOne($id);
        if (!$productApi) {
            return [];
        }

        $response = [];
        $collection = $productApi->getCollectionName();
        //$result = (new Query())->from($collection)->limit(1)->one();
        $result = Yii::$app->mongodb->getCollection($collection)->findOne();

        if (!$result) {
            return [];
        }

        // Filter out unwanted fields and arrays
        $excludedKeys = ['_id', 'fetched_at', 'company_id', 'id'];
        $res = array_keys(array_filter($result, function ($value, $key) use ($excludedKeys) {
            return !is_array($value) && !in_array($key, $excludedKeys);
        }, ARRAY_FILTER_USE_BOTH));

        $collection = (new Query())->from($collection);
        foreach ($res as $field) {
            $distinctValues = $collection->distinct($field);
            if (!Utils::allValuesAreNumbersOrDates($distinctValues)) {
                $mapped = [];
                foreach ($distinctValues as $value) {
                    if (!is_array($value)) {
                        $key = is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
                        $label = match (strtolower($key)) {
                            'true' => 'True',
                            'false' => 'False',
                            'yes' => 'Yes',
                            'no' => 'No',
                            default => ucfirst($key),  // Capitalize first letter
                        };
                        $mapped[$key] = $label;
                    }
                }
                $response[] = [
                    "key" => $field,
                    "values" => $mapped
                ];
            } else {
                $response[] = [
                    "key" => $field,
                    "values" => ""
                ];
            }
        }

        return $response;
    }



    public function actionAddComponent($id)
    {
        $company = Company::findOne($id);
        if (!$company instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }

        $model = new ComponentModel(["scenario" => "create"]);
        $model->company_id = $company->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Component added successfully.");
            return $this->redirect(['company/view-company', "dash" => -1, 'id' => $id]);
        }

        return $this->render('form-component', [
            'company' => $company,
            "products" => $id,
            "model" => $model
        ]);
    }

    public function actionUpdateComponentList($company_id, $id)
    {
        $company = Company::findOne($company_id);
        if (!$company instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }

        $component = ProductsApiCompanyMapping::findOne(['id' => $id]);
        if (!$component instanceof ProductsApiCompanyMapping) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/view-company', "dash" => -1, 'id' => $company->id]);
        }

        $model = new ComponentModel(["scenario" => "update"]);
        $model->company_id = $company->id;
        $model->api_id = $component->api_id;
        $model->id = $component->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Component updated successfully.");
            return $this->redirect(['company/view-company', "dash" => -1, 'id' => $company->id]);
        }

        $model->load($component->attributes, "");
        $apiData = $this->getApiResponseData($model->api_id);

        return $this->render('form-component-update', [
            'company' => $company,
            "products" => $id,
            "model" => $model,
            "apiData" => $apiData,
        ]);
    }

    public function actionChangePassword($id)
    {
        $company = Company::findOne($id);
        if (!$company instanceof Company) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['company/company']);
        }
        $model = new ChangePasswordForm(['scenario' => User::SCENARIO_CREATE]);
        $model->user_id = $company->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $company->password = $model->password;
            $company->save();
            \Yii::$app->getSession()->setFlash('s', "Password updated successfully.");
            return $this->redirect(['company/company', 'id' => $company->id]);
        }

        return $this->render('change-password', [
            'company' => $company,
            "model" => $model
        ]);
    }

    public function actionDashboardDetail($col, $company_id)
    {
        $data = (new Query())->from($col)->where(['company_id' => (int) $company_id])->all();

        $unsetColumns = ['_id', 'id', "company_id", "fetched_at"];
        $diplayColumns = [];
        $colredefined = explode("_", str_replace("-", "_", $col));
        unset($colredefined[count($colredefined) - 1]);
        $colredefined = implode("_", $colredefined);
        if (str_contains($colredefined, "users")) {
            $diplayColumns = ["firstname", "lastname", "email", "state", "suspended", "password_date", "password_expired", "totp_enabled"];
        }
        if (str_contains($colredefined, "managed_device")) {
            $diplayColumns = ["active", "displayName", "osFamily", "os", "version", "archFamily", "arch", "mdm", "isPolicyBound", "policyStats", "allowMultiFactorAuthentication", "lostMode", "lastContact", "agentVersion"];
        }

        $response = $columns = $fields = [];
        foreach ($data as $doc) {
            $res = [];
            foreach ($doc as $k => $val) {
                if (empty($response)) {
                    if (!is_array($val) && !in_array($k, $unsetColumns)) {
                        if (empty($diplayColumns)) {
                            $columns[] = "$k:text:" . Utils::convertToHeaderCase($k);
                            $fields[] = $k;
                        }
                    }
                }
                if (!is_array($val) && !in_array($k, $unsetColumns)) {
                    if (!empty($diplayColumns) && in_array($k, $diplayColumns)) {
                        $res[$k] = $val;
                    } else if (empty($diplayColumns)) {
                        $res[$k] = $val;
                    }
                }
            }
            $response[] = $res;
        }

        if (!empty($diplayColumns)) {
            $columns = [];
            foreach ($diplayColumns as $col) {
                $columns[] = "$col:text:" . Utils::convertToHeaderCase($col);
            }
            $fields = $diplayColumns;
        }

        $searchModel = new \yii\base\DynamicModel($fields);
        foreach ($fields as $field) {
            $searchModel->addRule($field, 'safe');
        }

        $filters = Yii::$app->request->get();
        if ($searchModel->load($filters)) {
            $data = array_filter($response, function ($item) use ($searchModel) {
                foreach ($searchModel->attributes as $field => $value) {
                    if ($value === '' || !isset($item[$field]))
                        continue;
                    if (stripos((string) $item[$field], $value) === false) {
                        return false;
                    }
                }
                return true;
            });
            $response = $data;
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $response,
            'pagination' => [
                'pageSize' => 100,
            ]
        ]);
        if (empty($columns)) {
            $columns = ["Srno"];
        }

        return $this->render('collection-list', [
            'dataProvider' => $dataProvider,
            "columns" => $columns,
            'searchModel' => $searchModel,
            "title" => $this->getTitle($col),
        ]);
    }

    private function getTitle($input)
    {
        $clean = preg_replace('/\d+/', '', $input);

        // Split by underscore and take first part
        $parts = explode('_', $clean);
        $word = $parts[0] ?? '';

        // Convert plural to singular (basic rule: remove trailing 's' if present)
        $word = rtrim($word, 's');

        // Convert to Title Case
        return ucfirst(strtolower($word));
    }

}
