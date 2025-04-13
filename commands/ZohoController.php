<?php

namespace app\commands;

use app\component\Constants;
use app\models\TicketComments;
use app\models\Tickets;
use app\component\Zoho;
use app\services\FetchData;
use Yii;

class ZohoController extends ConsoleController
{

    private $zoho;
    public function init()
    {
        $this->initateSession(Constants::CONSOLE_ID);
        $this->init_time = date("Y-m-d H:i:s");
        $this->zoho = new Zoho();
    }

    private function registerNewComplaints()
    {
        $model = Tickets::find()->where(["zoho_id" => null])->all();
        foreach ($model as $m) {
            $data = [
                'subject' => $m->subject,
                'description' => $m->description,
                'departmentId' => Yii::$app->params['zoho']['DEPARTMENT_ID'],
                'priority' => Constants::LABEL_PRIORITY[$m->priority],
                'status' => "OPEN",
                "contact" => [
                    "firstName" => $m->addedByUser->name,
                    "lastName" => "",
                    "email" => $m->addedByUser->email,
                    "phone" => $m->addedByUser->mobile_no,
                ]
            ];
            $response = $this->zoho->createComplaint($data);
            echo "Ticket created for  {$m->subject}---{$response}" . PHP_EOL;
            if (!empty($response) && !is_array($response)) {
                $m->zoho_id = $response;
                $m->save();
            }
            print_r($response);
        }
    }

    private function addComments()
    {
        $model = TicketComments::find()->where(["zoho_comment_id" => null])->all();
        foreach ($model as $m) {
            if (!empty($m->ticket->zoho_id)) {
                $data = [
                    'content' => $m->comment,
                    'isPublic' => true
                ];
                $response = $this->zoho->updateReply($m->ticket->zoho_id, $data);
                echo "Ticket comment added for  {$m->comment}---{$response}" . PHP_EOL;
                if (!empty($response) && !is_array($response)) {
                    TicketComments::updateAll(['zoho_comment_id' => $response], ['id' => $m->id]);
                    $m->refresh();
                }
            }
        }
    }

    private function closeTickets()
    {
        $model = Tickets::find()->where(['not', ["zoho_id" => null]])
            ->andWhere(["status" => Constants::CLOSED])->all();
        foreach ($model as $m) {
            if ($m->zoho_id) {
                $data = [
                    "status" => "Closed",
                    "resolution" => $m->resolution,
                ];
                $response = $this->zoho->closeTicket($m->zoho_id, $data);
                print_r($response);
                echo "Ticket closed for  {$m->subject}---{$response}" . PHP_EOL;
            }
        }
    }

    public function actionZoho()
    {
        //$this->registerNewComplaints();
        //$this->addComments();
        $this->closeTickets();
    }

}