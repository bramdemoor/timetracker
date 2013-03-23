<?php

namespace Library\DataLayer;

use Library\DataLayer\DatabaseConnection,
    DateTime;

class DatabaseLayer extends DatabaseConnection
{
    //TODO: create decent layer for business logic

    private static $m_pInstance;

    public static function getInstance()
    {
        if (!self::$m_pInstance)
        {
            self::$m_pInstance = new DatabaseLayer();
        }

        return self::$m_pInstance;
    }

    public function __construct() {
        parent::__construct();
    }

    public function hostInfo() {
        echo self::$mysql->host_info . "\n";
    }

    public function getAllEntries() {
       $result = self::$mysql->query("SELECT * FROM entries", MYSQLI_STORE_RESULT);

       if($result == null)  {
           echo self::$mysql->error;
           exit;
       }

       $returnSet = array();
       while($picksRow = $result->fetch_array(MYSQLI_ASSOC)) {
           array_push($returnSet, $picksRow);
       }

       $result->free();

       return $returnSet;
    }

    public function getAllEntriesSorted() {
        $entries = self::getAllEntries();
        rsort($entries);

        $returnArray =  array();
        foreach($entries as &$value) {
            $date = date('d-m-Y', strtotime($value['Start']));
            $returnArray[$date][] = $value;
        }
        krsort($returnArray);

        return $returnArray;
    }

    public function insertTask($tscode, $task, $start) {
        self::$mysql->query("INSERT INTO entries (TSCode, Task, Start) VALUES ('". $tscode ."', '". $task ."', '". date("Y-m-d H:i:s", $start) ."')");
        self::$mysql->commit();
    }

    public function updateTaskDescription($id, $task) {
        self::$mysql->query("UPDATE entries SET Task='". $task ."' WHERE Id='". $id ."'");
        self::$mysql->commit();
    }

    public function deleteEntry($id) {
        self::$mysql->query("DELETE from entries WHERE Id='". $id ."'");
        self::$mysql->commit();
    }

    public function getDistinctItems() {
        $result = self::$mysql->query("SELECT DISTINCT Task FROM entries", MYSQLI_STORE_RESULT);

        if($result == null)  {
            echo self::$mysql->error;
            exit;
        }

        $returnSet = array();
        while($picksRow = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($returnSet, $picksRow);
        }

        $result->free();

        return $returnSet;
    }

    public function getDistinctTsCodes() {
        $result = self::$mysql->query("SELECT DISTINCT TSCode FROM entries", MYSQLI_STORE_RESULT);

        if($result == null)  {
            echo self::$mysql->error;
            exit;
        }

        $returnSet = array();
        while($picksRow = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($returnSet, $picksRow);
        }

        $result->free();

        return $returnSet;
    }

    public function getAllEntriesGroupedByTask() {
        $entries = self::getAllEntries();

        //calculate TimeSpent per Entry
        $countEntries = count($entries);
        for ($i=0; $i<$countEntries; $i++)
        {
            if(isset($entries[$i + 1])) {
                $current = new DateTime($entries[$i]['Start']);
                $next = new DateTime($entries[$i + 1]['Start']);
                $diff = $current->diff($next);
                $entries[$i]['TimeSpent'] = $diff;
            } else {
                //calculate time for last task until now
                $current = new DateTime($entries[$i]['Start']);
                $next = new DateTime();
                $diff = $current->diff($next);
                $entries[$i]['TimeSpent'] = $diff;
            }
        }
        array_reverse($entries, true);

        //group Entries by Date
        $groupedByDate =  array();
        foreach($entries as &$value) {
            if($value['TSCode'] == 'Stop')  {
                //ditch unneeded Stop entries
                unset($entries[$i]);
            }
            else {
                $date = date('d-m-Y', strtotime($value['Start']));
                $groupedByDate[$date][] = $value;
            }
        }
        krsort($groupedByDate);

        //group entries per TSCode, calculate total time per TSCode, calculate TotalTimeSpent
        $groupedByTask = array();
        foreach($groupedByDate as $k => $v) {
            $summarised = array();
            $totalTimeSpent = new DateTime('00:00');
            $totalTimeSpentExclBreaks = new DateTime('00:00');
            foreach($v as &$entry) {
                if(isset($entry['TimeSpent']) && isset($summarised[$entry['TSCode']])) {
                    $summarised[$entry['TSCode']]['TimeSpent']->add($entry['TimeSpent']);
                    $totalTimeSpent->add($entry['TimeSpent']);
                    if($entry['TSCode'] != 'Break') $totalTimeSpentExclBreaks->add($entry['TimeSpent']);
                } elseif(isset($entry['TimeSpent'])) {
                    $summarised[$entry['TSCode']]['TimeSpent'] = (new DateTime('00:00'))->add($entry['TimeSpent']);
                    $totalTimeSpent->add($entry['TimeSpent']);
                    if($entry['TSCode'] != 'Break') $totalTimeSpentExclBreaks->add($entry['TimeSpent']);
                }
                if(isset($entry['Task'])) $summarised[$entry['TSCode']]['Summary'][] = $entry['Task'];
            }
            $groupedByTask[$k]['TSCodes'] = $summarised;
            $groupedByTask[$k]['TotalTimeSpent'] = $totalTimeSpent;
            $groupedByTask[$k]['TotalTimeSpentExclBreaks'] = $totalTimeSpentExclBreaks;
        }

        return $groupedByTask;
    }

    public function getExportDataGroupedByDayAndTask() {
        $entries = self::getAllEntries();

        //calculate TimeSpent per Entry
        $countEntries = count($entries);
        for ($i=0; $i<$countEntries; $i++)
        {
            if(isset($entries[$i + 1])) {
                $current = new DateTime($entries[$i]['Start']);
                $next = new DateTime($entries[$i + 1]['Start']);
                $diff = $current->diff($next);
                $entries[$i]['TimeSpent'] = $diff;
            } else {
                //calculate time for last task until now
                $current = new DateTime($entries[$i]['Start']);
                $next = new DateTime();
                $diff = $current->diff($next);
                $entries[$i]['TimeSpent'] = $diff;
            }
        }
        array_reverse($entries, true);

        //group Entries by Date
        $groupedByDate =  array();
        foreach($entries as &$value) {
            if($value['TSCode'] == 'Stop' || $value['TSCode'] == 'Break')  {
                //ditch unneeded Stop or Break entries
                unset($entries[$i]);
            }
            else {
                $date = date('d-m-Y', strtotime($value['Start']));
                $groupedByDate[$date][] = $value;
            }
        }
        krsort($groupedByDate);

        //group entries per TSCode, calculate total time per TSCode, calculate TotalTimeSpent
        $groupedByTask = array();
        foreach($groupedByDate as $k => $v) {
            $summarised = array();
            foreach($v as &$entry) {
                if(isset($entry['TimeSpent']) && isset($summarised[$entry['TSCode']])) {
                    $summarised[$entry['TSCode']]['TimeSpent']->add($entry['TimeSpent']);
                } elseif(isset($entry['TimeSpent'])) {
                    $summarised[$entry['TSCode']]['TimeSpent'] = (new DateTime('00:00'))->add($entry['TimeSpent']);
                }
                if(isset($entry['Task'])) $summarised[$entry['TSCode']]['Summary'][] = $entry['Task'];
            }
            $groupedByTask[$k]['TSCodes'] = $summarised;
        }

        return $groupedByTask;
    }
}
