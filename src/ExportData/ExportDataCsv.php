<?php

namespace Library\ExportData;

use Library\ExportData\ExportData;

class ExportDataCsv extends ExportData {

    function generateRow($row) {
        foreach ($row as $key => $value) {
            $row[$key] = '"'. str_replace('"', '\"', $value) .'"';
        }
        return implode(",", $row) . "\n";
    }
}
