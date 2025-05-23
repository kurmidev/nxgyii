<?php

namespace app\controllers;

use app\form\ChangePasswordForm;
use app\models\TicketComments;
use Yii;
use yii\web\Response;
use app\models\LoginForm;
use app\models\User;
use app\component\Constants as C;
use app\component\Constants;
use app\models\Categories;
use app\models\Company;
use app\models\Tickets;
use OneLogin\Saml2\Auth;
use yii\helpers\ArrayHelper;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userType = User::loggedInUserType();
        if (in_array($userType , [C::USERTYPE_CLIENT,C::USERTYPE_COMPANY])) {
            $user = User::currentUser();
            $url[] = "company/view-company";
            $url["id"] =  $user->company_id;
            if($userType == C::USERTYPE_CLIENT){
                $url["employee_id"] = $user->client_id;
            }
            return $this->redirect($url);
        } elseif (in_array($userType, [C::USERTYPE_ADMIN,C::USERTYPE_MSO])) {
            return $this->render('admin-index', [
                "complaint" => $this->getComplaintDashboardData()
            ]);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        // $auth = new Auth(require Yii::getAlias('@app/config/saml.php'));
        // $auth->logout(Yii::$app->urlManager->createUrl("site/login"));
        return $this->goHome();
    }

    public function actionChangesPassword()
    {
        $model = new ChangePasswordForm(['scenario' => User::SCENARIO_CREATE]);
        $name = User::loggedInUserName();
        $model->user_id = User::loggedInUserId();
        $model->name = $name;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $m = $model->save();
            \Yii::$app->getSession()->setFlash('s', "Password of $name updated successfully.");
            return $this->redirect(['index']);
        }
        return $this->render('form-change-password', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        $model = User::findOne(['id' => User::loggedInUserId()]);
        if (!$model instanceof User) {
            Yii::$app->getSession()->setFlash('e', 'No record found');
            return $this->redirect(['site/profile']);
        }

        $model->scenario = User::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('s', "User $model->name updated successfully.");
            return $this->redirect(['site/index']);
        }

        return $this->render('form-user', [
            'model' => $model,
            'isReadonly' => false
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    // public function actionUser()
    // {
    //     $searchModel = new UserSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     $dataProvider->query->andWhere(['user_type' => [C::USERTYPE_MSO, C::USERTYPE_STAFF, C::USERTYPE_OPERATOR]]);

    //     return $this->render('user', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionAddUser()
    // {
    //     $model = new UserForm(['scenario' => User::SCENARIO_CREATE]);
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         \Yii::$app->getSession()->setFlash('s', "User $model->name added successfully.");
    //         return $this->redirect(['site/user']);
    //     }
    //     return $this->render('form-user', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdateUser($id)
    // {
    //     $user = User::findOne($id);

    //     if (!$user instanceof User) {
    //         \Yii::$app->getSession()->setFlash('e', 'User not found');
    //         return $this->redirect(['site/user']);
    //     }
    //     $model = new UserForm(['scenario' => User::SCENARIO_UPDATE]);
    //     $model->id = $user->id;
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         $model->save();
    //         \Yii::$app->getSession()->setFlash('s', "User $model->name updated successfully");
    //         return $this->redirect(['site/user']);
    //     }

    //     $model->load($user->attributes, '');
    //     $model->password = "";
    //     return $this->render('form-user', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionAccessdenied()
    {
        return $this->render('accessdenied');
    }

    private function getComplaintDashboardData()
    {
        $complaint = Tickets::find()->groupBy(["status", "company_id", "sub_category_id"])->select(["status", "company_id", "sub_category_id", "count" => "count(id)"])->asArray()->all();
        $compayWise = $generalWise = $subCategoryWise = [];
        $category = ArrayHelper::map(Categories::find()->onlyChild()->all(), "id", "name");
        $company = ArrayHelper::map(Company::find()->all(), "id", "name");
        foreach ($complaint as $c) {

            $compayWise[$company[$c["company_id"]]][Constants::LABEL_COMPLAINT_STATUS[$c["status"]]] =
                !empty($compayWise[$company[$c["company_id"]]][Constants::LABEL_COMPLAINT_STATUS[$c["status"]]]) ?
                $compayWise[$company[$c["company_id"]]][Constants::LABEL_COMPLAINT_STATUS[$c["status"]]] + $c["count"] :
                $c["count"];


            $generalWise[Constants::LABEL_COMPLAINT_STATUS[$c["status"]]] =
                !empty($generalWise[Constants::LABEL_COMPLAINT_STATUS[$c["status"]]]) ?
                $generalWise[Constants::LABEL_COMPLAINT_STATUS[$c["status"]]] + $c["count"] : $c["count"];

            $subCategoryWise[$category[$c["sub_category_id"]]][Constants::LABEL_COMPLAINT_STATUS[$c["status"]]] =
                !empty($subCategoryWise[$category[$c["sub_category_id"]]][Constants::LABEL_COMPLAINT_STATUS[$c["status"]]]) ?
                $subCategoryWise[$category[$c["sub_category_id"]]][Constants::LABEL_COMPLAINT_STATUS[$c["status"]]] + $c["count"] :
                $c["count"];
        }

        $rating = Tickets::find()->select("avg(rating) as rating")->asArray()->one();

        $query = "SELECT COUNT(t.id) AS total_tickets, MIN(TIMESTAMPDIFF(MINUTE, t.added_on, tc.first_comment_time)) AS first_response_time_minutes,
    AVG(first_response_minutes) AS avg_response_time_minutes, AVG(TIMESTAMPDIFF(HOUR, t.added_on, t.end_date)) AS avg_resolution_time_hours,
    ROUND(100 * COUNT(DISTINCT tc.ticket_id) / COUNT(t.id)) AS response_coverage_percentage,
    ROUND(100 * COUNT(t.end_date) / COUNT(t.id)) AS resolution_coverage_percentage FROM tickets t
LEFT JOIN (
    SELECT 
        ticket_id,
        MIN(tc.added_on) AS first_comment_time,
        TIMESTAMPDIFF(MINUTE, MIN(tk.added_on), MIN(tc.added_on)) AS first_response_minutes
    FROM ticket_comments tc
    JOIN tickets tk ON tk.id = tc.ticket_id
    GROUP BY ticket_id
) AS tc ON t.id = tc.ticket_id;";

        $reponseDetails = Yii::$app->db->createCommand($query)->queryAll();
        return [
            "compayWise" => $compayWise,
            "generalWise" => $generalWise,
            "subCategoryWise" => $subCategoryWise,
            "rating" => !empty($rating["rating"]) ? $rating["rating"] : 0,
            "reponsetime" => !empty($reponseDetails[0]) ? $reponseDetails[0] : [
                "first_response_time_minutes" => 0,
                "avg_response_time_minutes" => 0,
                "avg_resolution_time_hours" => 0
            ]
        ];
    }

    public function actionDownloadFile($id)
    {
        $model = TicketComments::findOne($id); // assuming you have a Document model

        if (!$model) {
            throw new \yii\web\NotFoundHttpException("File not found.");
        }

        // Assuming you store base64 content and file metadata in DB
        $base64Data = $model->attachment["fileContent"]; // base64 string
        $fileName = $model->attachment["name"];   // e.g., "document.pdf"
        $mimeType = $model->attachment["type"];   // e.g., "application/pdf"

        $decoded = base64_decode($base64Data);

        return Yii::$app->response->sendContentAsFile(
            $decoded,
            $fileName,
            ['mimeType' => $mimeType]
        );
    }


}
