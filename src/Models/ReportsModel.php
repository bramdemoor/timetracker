<?php

namespace Models;

use Library\DataLayer\DatabaseLayer;

class ReportsModel
{
    public function __construct() {
    }

    public function getEntriesGroupedByTask() {
        $arr = DatabaseLayer::getInstance()->getAllEntriesGroupedByTask();
        return $arr;
    }
}
