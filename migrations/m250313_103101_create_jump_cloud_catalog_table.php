<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jump_cloud_catalog}}`.
 */
class m250313_103101_create_jump_cloud_catalog_table extends Migration
{
    public $tableName = "jumpcloud_catalog";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id"=> $this->string(),
            "operatingSystem"=> $this->string(),
            "name"=> $this->string(),
            "version"=> $this->string(),
            "build"=> $this->string(),
            "releaseTimestamp"=> $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try{
            $this->dropTable($this->tableName);
        }catch(Exception $e){

        }
        
    }
}
