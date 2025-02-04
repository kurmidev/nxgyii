<?php

namespace app\component;

use yii\widgets\LinkPager;

class CtGridPagination extends LinkPager {

    public function init() {
        parent::init();
    }

    public function run() {
        parent::run();
    }

    protected function renderPageButton($label, $page, $class, $disabled, $active) {

        $this->pageCssClass = "page-item";
        $this->linkOptions['class'] = "page-link";
        return parent::renderPageButton($label, $page, $class, $disabled, $active);
    }

    protected function renderPageButtons() {
        $this->options["class"] = "pagination pagination-circle mg-b-0";
        $this->firstPageCssClass = "page-item hidden-xs-down";
        $this->lastPageCssClass = "page-item hidden-xs-down";
        $this->prevPageCssClass = $this->nextPageCssClass = "page-item";
        $this->prevPageLabel = false;
        $this->nextPageLabel = false;
        return parent::renderPageButtons();
    }

}
