<?php

namespace Library\ExportData;

abstract class ExportData {

    protected $stringData;
    protected $tempFile;
    protected $tempFilename;
    protected $exportsFolders;

    public $filename;

    public function __construct($exportsFolder, $filename) {
        $this->filename = $filename;
        $this->exportsFolders = $exportsFolder;
    }

    public function initialize() {
        $this->tempFilename = tempnam(sys_get_temp_dir(), 'exportdata');
        $this->tempFile = fopen($this->tempFilename, "w");
    }

    public function addRow($row) {
        $this->write($this->generateRow($row));
    }

    public function finalize() {
        fclose($this->tempFile);
        rename($this->tempFilename, $this->exportsFolders . $this->filename);
    }

    public function getString() {
        return $this->stringData;
    }

    protected function write($data) {
        fwrite($this->tempFile, $data);
    }

    abstract protected function generateRow($row);
}