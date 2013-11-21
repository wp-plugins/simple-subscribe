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


if(!class_exists('WP_List_Table')){ require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ); }

abstract class Table extends \WP_List_Table
{
    /** @var array() */
    var $notices;

    /**
     * No Items notices
     */

    function no_items(){ _e('No items to be listed.'); }


    /**
     * Reordering function.
     *
     * @param $a
     * @param $b
     * @return int
     */

    function usort_reorder($a, $b)
    {
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
        $result = strcmp($a[$orderby], $b[$orderby]);
        return ($order === 'asc') ? $result : -$result;
    }


    /**
     * Default columns display behaviour
     *
     * @param $item
     * @param $column_name
     * @return mixed
     */

    function column_default($item, $column_name){ return $item[$column_name]; }


    /**
     * Get notices
     *
     * @return mixed
     */

    public function getNotices(){ return $this->notices; }


    /**
     * Has Messages
     *
     * @return bool
     */

    public function hasNotices(){ if(!empty($this->notices)){ return TRUE; } return FALSE; }


    /**
     * Adds Message to be returned later - anywhere we want
     *
     * @param $key
     * @param $msg
     */

    public function addNotice($key, $msg)
    {
        $this->notices[] = array($key, $msg);
        Admin::getInstance()->displayAdminNotice($key, $msg);
    }
}
