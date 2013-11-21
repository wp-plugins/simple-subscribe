<?php

/**
 * This file is part of the Simple Subscribe plugin.
 *
 * Copyright (c) 2013 Martin Pícha (http://latorante.name)
 *
 * For the full copyright and license information, please view
 * the SimpleSubscribe.php file in root directory of this plugin.
 */

namespace SimpleSubscribe;


class Exporter
{
    /** @var array */
    var $columnHeaders;
    /** @var \SimpleSubscribe\RepositorySubscribers */
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
        $this->subscribers = \SimpleSubscribe\RepositorySubscribers::getInstance();
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
                $this->exporter = new \SimpleSubscribe\ExporterExcel('browser', $this->fileName . '.xls');
                $this->exporter->addRow($this->columnHeaders);
                foreach($this->subscribers->getByCriteria($criteria) as $subscriber){
                    $this->exporter->addRow(array_values($subscriber));
                }
                break;
            case 'csv':
                $this->exporter = new \SimpleSubscribe\ExporterCSV('browser', $this->fileName . '.csv');
                $this->exporter->addRow($this->columnHeaders);
                foreach($this->subscribers->getByCriteria($criteria) as $subscriber){
                    $this->exporter->addRow(array_values($subscriber));
                }
                break;
            case 'tsv':
                $this->exporter = new \SimpleSubscribe\ExporterTSV('browser', $this->fileName . '.tsv');
                $this->exporter->addRow($this->columnHeaders);
                foreach($this->subscribers->getByCriteria($criteria) as $subscriber){
                    $this->exporter->addRow(array_values($subscriber));
                }
                break;
            case 'xml':
                $this->exporter = new \SimpleSubscribe\ExporterXML($this->fileName . '.xml');
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