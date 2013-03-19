<?php

namespace Models;

use Library\DataLayer\DatabaseLayer,
    DateTime;

class ReportsModel
{
    public function __construct() {
    }

    public function getEntriesGroupedByTask() {
        $entries = DatabaseLayer::getInstance()->getAllEntries();

        //calculate TimeSpent per Entry
        for ($i=0; $i<=count($entries); $i++)
        {
            if($entries[$i]['TSCode'] == 'Stop') {
                //ditch unneeded Stop entries
                unset($entries[$i]);
            } else {

                if(isset($entries[$i + 1])) {
                    $current = new DateTime($entries[$i]['Start']);
                    $next = new DateTime($entries[$i + 1]['Start']);
                    $diff = $current->diff($next);
                    $entries[$i]['TimeSpent'] = $diff;
                }
            }
        }
        array_reverse($entries, true);

        //group Entries by Date
        $groupedByDate =  array();
        foreach($entries as &$value) {
            $date = date('d-m-Y', strtotime($value['Start']));
            $groupedByDate[$date][] = $value;
        }
        krsort($groupedByDate);

        //group entries per TSCode, calculate total time per TSCode, calculate TotalTimeSpent
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
        }

        return $groupedByTask;
    }
}
