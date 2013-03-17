<?php

namespace Models;

use Library\DataLayer\DatabaseLayer;

class ReportsModel
{
    public function __construct() {
    }

    public function getEntriesGroupedByTask() {
        $entries = DatabaseLayer::getInstance()->getAllEntries();

        //TODO: calculate time spent per task

        //group by date
        $groupedByDate =  array();
        foreach($entries as &$value) {
            $date = date('d-m-Y', strtotime($value['Start']));
            $groupedByDate[$date][] = $value;
        }
        ksort($groupedByDate);

        //group by task, summarize description, sum calculated time
        $groupedByTask = array();
        foreach($groupedByDate as $k => $v) {
            $descrSummary = array();
            foreach($v as &$entry) {
                $descrSummary[$entry['TSCode']][] = $entry['Task'];
            }
            $groupedByTask[$k] = $descrSummary;
        }
        return $groupedByTask;
    }
}
