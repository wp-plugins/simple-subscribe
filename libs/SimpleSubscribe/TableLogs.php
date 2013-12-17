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


use Nette\Utils\Html;

class TableLogs extends Table
{
    /** @var \SimpleSubscribe\RepositoryLog */
    var $log;


    /**
     * Constructor
     *
     * @param RepositoryLog $log
     */

    function __construct(\SimpleSubscribe\RepositoryLog $log)
    {
        global $status, $page;
        $this->log = $log;
        parent::__construct(array('singular'=> 'log', 'plural' => 'logs', 'ajax' => false));
    }


    /**
     * Basic setup, returns table columns.
     *
     * @return array
     */

    function get_columns()
    {
        return array(
            'type' => 'Type',
            'date' => 'Date',
            'message' => 'Log Message'
        );
    }


    /**
     * Basic setup, returns sortable columns
     *
     * @return array
     */

    function get_sortable_columns()
    {
        return array(
            'type' => array('type',false),
            'date' => array('date',false)
        );
    }


    /**
     * Type of message
     *
     * @param $item
     * @return string
     */

    function column_type($item)
    {
        if($item['type'] == 0){
            $type = \Nette\Utils\Html::el('strong class="error"')->setText('Error');
        } else {
            $type = \Nette\Utils\Html::el('strong')->setText('Message');
        }
        $actions = array( 'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete Message</a>',$_GET['page'],'delete',$item['id']));
        return sprintf('%1$s %2$s', $type, $this->row_actions($actions));
    }


    /**
     * Date
     *
     * @param $item
     * @return Nette\Utils\Html
     */

    function column_date($item)
    {
        return \Nette\Utils\Html::el('span title="'. $item['date'] .'"')->setText($item['date']);
    }



    /**
     * No Items notices
     */

    function no_items(){ _e('No log messages.'); }


    /**
     *  Prepares, sorts, delets, all that stuff :)
     */

    function prepare_items()
    {
        $this->process_bulk_action();
        $allLogs = $this->log->getAll();
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());
        usort($allLogs, array(&$this, 'usort_reorder'));
        $perPage = 50; // set per page
        $this->found_data = array_slice($allLogs,(($this->get_pagenum()-1)* $perPage), $perPage);
        $this->set_pagination_args(array('total_items' => count($allLogs), 'per_page' => $perPage));
        $this->items = $this->found_data;
    }


    /**
     * Claring log messages
     */

    public function process_bulk_action()
    {
        try {
            switch ($this->current_action()){
                case 'emptyLog':
                    $this->log->truncate();
                    $this->addNotice('updated', 'All log messages cleared!');
                    break;
                case 'delete':
                    if(is_numeric($_GET['id'])){
                        $this->log->delete(array('id' =>$_GET['id'] ));
                        $this->addNotice('updated', 'Log message deleted!');
                    }
                    break;
            }
        } catch (RepositaryLogException $e){
            $this->addNotice('error', $e->getMessage());
        }
    }
}
