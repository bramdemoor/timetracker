<?php

namespace Models;

use Library\DataLayer\DatabaseLayer,
    DateTime;

use FirePHP;
require_once('FirePHP.class.php');
ob_start();

class ReportsModel
{
    public function __construct() {
    }

    public function getEntriesGroupedByTask() {
        $entries = DatabaseLayer::getInstance()->getAllEntries();
        $fp = FirePHP::getInstance(true);

        for ($i=0; $i<=count($entries); $i++)
        {
            if(isset($entries[$i + 1])) {
                $current = new DateTime($entries[$i]['Start']);
                $next = new DateTime($entries[$i + 1]['Start']);
                $diff = $current->diff($next);
                $entries[$i]['TimeSpent'] = $diff;
            }

        }

        array_reverse($entries, true);

        $groupedByDate =  array();
        foreach($entries as &$value) {
            $date = date('d-m-Y', strtotime($value['Start']));
            $groupedByDate[$date][] = $value;
        }
        krsort($groupedByDate);

        $groupedByTask = array();
        foreach($groupedByDate as $k => $v) {
            $summarised = array();
            $totalTimeSpent = new DateTime('00:00');
            foreach($v as &$entry) {
                if(isset($entry['TimeSpent']) && isset($summarised[$entry['TSCode']])) {
                    $summarised[$entry['TSCode']]['TimeSpent']->add($entry['TimeSpent']);
                    $totalTimeSpent->add($entry['TimeSpent']);
                } elseif(isset($entry['TimeSpent'])) {
                    $summarised[$entry['TSCode']]['TimeSpent'] = (new DateTime('00:00'))->add($entry['TimeSpent']);
                    $totalTimeSpent->add($entry['TimeSpent']);
                }
                if(isset($entry['Task'])) $summarised[$entry['TSCode']]['Summary'][] = $entry['Task'];
            }
            $groupedByTask[$k]['TSCodes'] = $summarised;
            $groupedByTask[$k]['TotalTimeSpent'] = $totalTimeSpent;
            $fp->log($groupedByTask);
        }

        return $groupedByTask;
    }
}
