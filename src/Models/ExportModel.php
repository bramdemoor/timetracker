<?php

namespace Models;

use Library\DataLayer\DatabaseLayer,
    Library\ExportData\ExportDataCsv;

class ExportModel
{

    public function __construct() {
    }

    public function exportAllEntries($fileName) {
        $arr = DatabaseLayer::getInstance()->getExportDataGroupedByDayAndTask();

        //TODO: put Exports folder in setting
        $export = new ExportDataCsv("Exports/", $fileName);
        $export->initialize();

        foreach($arr as $day => $entries) {
            $parsed = explode('-', $day);
            $day = array_shift($parsed);
            $month = array_shift($parsed);
            $year = array_shift($parsed);
            foreach($entries['TSCodes'] as $tscode => $values) {
                $newRow = array();
                //$fp->log($values);
                //username
                array_push($newRow, 'vancari');
                //timesheetcode
                array_push($newRow, $tscode);
                //work day
                array_push($newRow, $day);
                //work month
                array_push($newRow, $month);
                //work year
                array_push($newRow, $year);
                //actual hours
                $calc = $this->calculateHoursFromTimeSpent($values['TimeSpent']);
                array_push($newRow, $calc);
                //description, concat summary entries
                $summary = '';
                foreach($values['Summary'] as $entry) {
                    $summary .= $entry. ', ';
                }
                array_push($newRow, $summary);
                $export->addRow($newRow);
            }
        }
        $export->finalize();
    }

    private function calculateHoursFromTimeSpent($timespent) {
        $minutes = $timespent->format('i');
        $hours = trim($timespent->format('H'), '0');
        $calcMinutes = round($minutes/60, 2, PHP_ROUND_HALF_UP);
        $calculated = $hours + $calcMinutes;
        return $calculated;
    }
}