<?php

namespace Models;

use Library\DataLayer\DatabaseLayer;

class EntriesModel
{
    public function __construct()
    {
    }

    public function getAllEntries() {
        $entries = DatabaseLayer::getInstance()->getAllEntries();
        rsort($entries);

        $returnArray =  array();
        foreach($entries as &$value) {
            $date = date('d-m-Y', strtotime($value['Start']));
            $returnArray[$date][] = $value;
        }
        krsort($returnArray);

        return $returnArray;
    }

    public function createNewEntry($tsCode, $description, $start) {
        DatabaseLayer::getInstance()->insertTask($tsCode, $description, $start);
    }

    public function updateTaskDescription($task, $id) {
        DatabaseLayer::getInstance()->updateTaskDescription($id, $task);
    }

    public function removeEntry($id) {
        DatabaseLayer::getInstance()->deleteEntry($id);
    }

    public function getEntryNames() {
        $arr = DatabaseLayer::getInstance()->getDistinctItems();
        return $arr;
    }

    public function getTsCodes() {
        $arr = DatabaseLayer::getInstance()->getDistinctTsCodes();
        return $arr;
    }
}
