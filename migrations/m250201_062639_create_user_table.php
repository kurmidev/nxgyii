<?php

use app\component\Constants;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m250201_062639_create_user_table extends Migration
{
    protected $tableName = 'user';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
        try{
            $this->dropTable($this->tableName);
        }catch(Exception $e){

        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'mobile_no' => $this->string(),
            'email' => $this->string(),
            'user_type' => $this->smallInteger()->notNull(),
            'company_id' => $this->integer(),
            'client_id' => $this->integer(),
            'designation_id' => $this->integer(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'verification_token' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(Constants::STATUS_ACTIVE),
            'last_access_time' => $this->dateTime()->null(),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $query = "insert into user(id,name,mobile_no,user_type,email,company_id,designation_id,username,password,status,auth_key,password_hash)";
        $query .= "values(" . Constants::CONSOLE_ID . ",'console','8923893289'," . Constants::USERTYPE_CONSOLE . ",'console@cabeltree.com',0," . Constants::DESIGNATION_SADMIN . ",'console',md5('console'),1,'". Yii::$app->security->generateRandomString()."','".Yii::$app->getSecurity()->generatePasswordHash("console")."')";
        Yii::$app->db->createCommand($query)->execute();

        Yii::$app->runAction('migrate', ['--migrationPath' => '@yii/rbac/migrations/']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
