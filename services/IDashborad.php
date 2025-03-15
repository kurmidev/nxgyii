<?php

namespace app\services;

interface IDashborad{
    public function getDashboardCounts():array;
    public function getData(string $report,array $filter):array;
}