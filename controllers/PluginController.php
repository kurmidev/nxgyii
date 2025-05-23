<?php

namespace app\controllers;

use app\component\Constants;
use app\form\ChangePasswordForm;
use app\models\Categories;
use app\models\CategoriesSearch;
use app\models\User;
use app\models\UserSearch;
use Yii;

class PluginController extends BaseController
{


    public function actionCategory()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->onlyParent();
        //$dataProvider->query->excludeSysDef();
        return $this->render('categories', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddCategory()
    {
        $model = new Categories(['scenario' => Categories::SCENARIO_CREATE]);
        $model->parent_id = 0;
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {

            Yii::$app->getSession()->setFlash('s', "Categories $model->name added successfully.");
            return $this->redirect(['plugin/category', 'id' => $model->id]);
        }
        return $this->render('form-category', [
            'model' => $model,
        ]);
    }

    public function actionUpdateCategory($id)
    {
        $model = Categories::findOne($id);
        $model->parent_id = 0;
        if (!$model instanceof Categories) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['plugin/category']);
        }

        $model->scenario = Categories::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "Category $model->name updated successfully.");
            return $this->redirect(['plugin/category']);
        }

        return $this->render('form-category', [
            'model' => $model,
        ]);
    }

    public function actionSubCategory()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->onlyChild();
        //$dataProvider->query->excludeSysDef();
        return $this->render('subcategories', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddSubCategory()
    {
        $model = new Categories(['scenario' => Categories::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (empty($model->parent_id)) {
                $model->addError('parent_id', 'Parent category is required.');
            }
            if (!$model->hasErrors()) {
                $model->save();
                Yii::$app->getSession()->setFlash('s', "Sub Categories $model->name added successfully.");
                return $this->redirect(['plugin/sub-category', 'id' => $model->id]);
            }
        }
        return $this->render('form-sub-category', [
            'model' => $model,
        ]);
    }

    public function actionUpdateSubCategory($id)
    {
        $model = Categories::findOne($id);

        if (!$model instanceof Categories) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['plugin/sub-category']);
        }

        $model->scenario = Categories::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (empty($model->parent_id)) {
                $model->addError('parent_id', 'Parent category is required.');
            }
            if (!$model->hasErrors()) {
                $model->save();
                Yii::$app->getSession()->setFlash('s', "Sub Category $model->name updated successfully.");
                return $this->redirect(['plugin/sub-category']);
            }
        }

        return $this->render('form-sub-category', [
            'model' => $model,
        ]);
    }

    public function actionUser()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['user_type' => Constants::USERTYPE_MSO]);
        return $this->render('user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Reason model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddUser()
    {
        $model = new User(['scenario' => User::SCENARIO_CREATE]);
        $model->user_type = Constants::USERTYPE_MSO;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "user $model->name added successfully.");
            return $this->redirect(['user', 'id' => $model->id]);
        } else {
            if ($model->errors) {
                print_R($model->errors);
                exit;
            }
        }
        return $this->render('form-user', [
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
    public function actionUpdateUser($id)
    {
        $model = User::findOne($id);

        if (!$model instanceof User) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['plugin/user']);
        }
        $model->user_type = Constants::USERTYPE_MSO;
        $model->scenario = User::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "User $model->name updated successfully.");
            return $this->redirect(['plugin/user']);
        }
        return $this->render('form-user', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword($id)
    {
        $user = User::findOne($id);
        if (!$user instanceof User) {
            \Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['plugin/user']);
        }
        $model = new ChangePasswordForm(['scenario' => User::SCENARIO_CREATE]);
        $model->user_id = $user->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('s', "Password updated successfully.");
            return $this->redirect(['plugin/user']);
        }

        return $this->render('change-password', [
            "model" => $model
        ]);
    }

}