<?php

namespace app\component;

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use app\component\ImsGridPagination;

class CtGridView extends GridView {

    public $noFooter;

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->tableOptions = ['class' => "table  table-hover table-bordered br-section-wrapper"];
    }

    public function renderPager() {
        $pagination = $this->dataProvider->getPagination();
        $this->noFooter = (!empty($pagination->pageSize) ? $pagination->pageSize : $pagination->defaultPageSize) < $pagination->totalCount ? TRUE : FALSE;
        if ($pagination === false || $this->dataProvider->getCount() <= 0 || !$this->noFooter) {
            return '';
        }

        /* @var $class LinkPager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', CtGridPagination::class);
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();
        return Html::tag(
                        "div", $class::widget($pager), ["class" => "ht-80 d-flex align-items-center justify-content-center mg-t-0 br-section-wrapper"]
        );
    }

    public function run() {
        $this->layout = $this->getImsGridLayout();
        parent::run();
    }

    public function getImsGridLayout() {
        //"{summary}\n{items}\n{pager}"


        $data = Html::tag('div', Html::tag(
                                "div", "{summary}{items}"
                                , ["class" => "table-responsive"])
                        , ["class" => "pd-t-15 card"]
        );
        $data .= $this->getPager();
        return $data;
    }

    public function getPager() {
        return "{pager}";
        //return Html::tag(
        //"div", "{pager}", ["class" => "ht-80 d-flex align-items-center justify-content-center mg-t-0 br-section-wrapper"]
        //);
    }

}
