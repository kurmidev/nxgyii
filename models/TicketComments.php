<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "ticket_comments".
 *
 * @property int $id
 * @property int $ticket_id
 * @property string $comment
 * @property string|null $attachment
 * @property string|null $zoho_comment_id
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class TicketComments extends \app\models\BaseModel
{

    public $attachmentUpload;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_id', 'comment'], 'required'],
            [['ticket_id', 'added_on', 'updated_on', 'added_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
            [['attachment'], 'safe'],
            [['attachmentUpload'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, pdf, doc, txt'],
            [['zoho_comment_id'], 'string', 'max' => 100],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['ticket_id', 'comment', 'attachment', 'zoho_comment_id', 'added_on', 'updated_on', 'added_by', 'updated_by','attachmentUpload'],
            self::SCENARIO_CREATE => ['ticket_id', 'comment', 'attachment', 'zoho_comment_id', 'added_on', 'updated_on', 'added_by', 'updated_by','attachmentUpload'],
            self::SCENARIO_UPDATE => ['ticket_id', 'comment', 'attachment', 'zoho_comment_id', 'updated_by', 'updated_at','attachmentUpload'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'comment' => 'Comment',
            'attachment' => 'Attachment',
            'zoho_comment_id' => 'Zoho Comment ID',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TicketCommentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketCommentsQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $uploadedFile = UploadedFile::getInstance($this, 'attachmentUpload');
            if ($uploadedFile) {
                $this->attachment = [
                    "name" => $uploadedFile->name,
                    "extension" => $uploadedFile->extension,
                    "type" => $uploadedFile->type,
                    "size" => $uploadedFile->size,
                    "fileContent" => base64_encode(file_get_contents($uploadedFile->tempName)),
                ];
            }
        }
        return parent::beforeSave($insert);
    }

    public function getTicket(){
        return $this->hasOne(Tickets::class, ['id' => 'ticket_id']);
    }
}
