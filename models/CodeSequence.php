<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "code_sequence".
 *
 * @property int $id
 * @property string|null $prefix
 * @property int|null $counter
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class CodeSequence extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'code_sequence';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['counter', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['prefix'], 'string', 'max' => 255],
            [['prefix'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prefix' => 'Prefix',
            'counter' => 'Counter',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getSequence($prefix) {
        $model = self::findOne(['prefix' => $prefix]);
        if (!$model instanceof CodeSequence) {
            $model = new CodeSequence();
        }
        $model->prefix = $prefix;
        $model->counter += 1;
        $model->save();
        return $model->counter;
    }
}
