<?php

namespace component\widgets;

use yii\base\Widget;

class CompanyTop extends Widget{
    public $userData;

    public function init(){
        parent::init();
        // Initialization code here, if any.
        $this->generateData();
    }

    public function generateData(){
    }

    public function run(){
        return $this->render('company-top');
    }
}

