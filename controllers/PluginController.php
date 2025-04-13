<?php

namespace app\controllers;

use app\models\Categories;
use app\models\CategoriesSearch;
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
}