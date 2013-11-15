<?php
if (!defined('ABSPATH')) { exit; }

class SimpleSubscribeExporter
{
    /** @var array */
    var $columnHeaders;
    /** @var bool|\SimpleSubscribeSubscribers */
    var $subscribers;
    /** @var string */
    var $fileName = 'subscribers';
    /** @var Exporter */
    var $exporter;


    /**
     * Constructor
     */

    public function __construct()
    {
        require_once('Exporter.php');
        $this->subscribers = SimpleSubscribeSubscribers::getInstance();
        $this->columnHeaders = $this->subscribers->getColumnHeaders();
    }


    /**
     * Export controller
     *
     * @param $type
     * @param $data
     */

    public function export($type, $criteria = 'all')
    {
        switch($type){
            case 'xls':
                $this->exporter = new ExporterExcel('browser', $this->fileName . '.xls');
                $this->exporter->addRow($this->columnHeaders);
                foreach($this->subscribers->getByCriteria($criteria) as $subscriber){
                    $this->exporter->addRow(array_values($subscriber));
                }
                break;
            case 'csv':
                $this->exporter= new ExporterCSV('browser', $this->fileName . '.csv');
                $this->exporter->addRow($this->columnHeaders);
                foreach($this->subscribers->getByCriteria($criteria) as $subscriber){
                    $this->exporter->addRow(array_values($subscriber));
                }
                break;
            case 'tsv':
                $this->exporter= new ExporterTSV('browser', $this->fileName . '.tsv');
                $this->exporter->addRow($this->columnHeaders);
                foreach($this->subscribers->getByCriteria($criteria) as $subscriber){
                    $this->exporter->addRow(array_values($subscriber));
                }
                break;
            case 'xml':
                $this->exporter = new ExporterXML($this->fileName . '.xml');
                foreach($this->subscribers->getByCriteria($criteria) as $subscriber){
                    $this->exporter->addRow($subscriber);
                }
                break;
        }
    }


    /**
     * Fin!
     */

    public function fin()
    {
        $this->exporter->finalize();
        die();
    }
}