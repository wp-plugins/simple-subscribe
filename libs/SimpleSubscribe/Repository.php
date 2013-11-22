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

use Nette\Utils\Html,
    Nette\Utils\Strings;

abstract class Repository extends \Nette\Object
{
    /** @var WPDB object */
    public $database;
    /** @var \SimpleSubscribe\Settings */
    public $settings;
    /** @var mixed */
    public $settingsAll;
    /** @var string */
    public $tableName;
    /** @var string */
    public $tableSingleName;
    /** @var mixed */
    public $count;

    /**
     * Constructor
     */

    public function __construct()
    {
        // get wordpress database object (no injection sorry!
        global $wpdb;
        // variables
        $this->database = $wpdb;
        $this->settings = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
        $this->settingsAll = $this->settings->getSettings();
        // we get the table name from class name
        preg_match('#Repository(\w+)$#', get_class($this), $class);
        $tablePreName = \Nette\Utils\Strings::contains($class[1], 'Subscribers') ? $class[1] : 'Subscribers' . $class[1];
        $this->tableName = $this->database->prefix . Utils::camelCaseToUnderscore($tablePreName);
        $this->tableSingleName = \Nette\Utils\Strings::firstUpper($class[1]);
        $this->count = $this->count();
    }


    /**
     * Get menu title
     *
     * @return string
     */

    public function menuTitle()
    {
        if($this->count > 0){
            return $this->tableSingleName . ' ' . Html::el('span class=update-plugins')->add(Html::el('span class="update-count"')->setText($this->count));
        }
        return $this->tableSingleName;
    }


    /**
     * Basic insert
     *
     * @param $data
     * @return mixed
     */

    public function insert($data){ return $this->database->insert($this->tableName, (array)$data); }


    /**
     * Basic getter
     *
     * @param string $what
     * @param null $condition
     * @param null $equals
     * @return mixed
     */

    public function get($what = '*', $condition = NULL, $equals = NULL)
    {
        if($condition && $equals){
            return $this->database->get_results("SELECT $what FROM $this->tableName WHERE $condition='$equals'", ARRAY_A);
        }
        return $this->database->get_results("SELECT $what FROM $this->tableName", ARRAY_A);
    }


    /**
     * Basic variable getter
     *
     * @param $var
     * @param $condition
     * @param $equals
     * @param null $database
     * @return mixed
     */

    public function getVar($var, $condition, $equals, $database = NULL)
    {
        $from = $database ? $database : $this->tableName;
        return $this->database->get_var("SELECT $var FROM $this->tableName WHERE $condition='$equals'");
    }


    /**
     * Getter for WP_List_Table class in admin
     *
     * @return mixed
     */

    public function getAll(){ return $this->get('*'); }


    /**
     * Getter for WP_List_Table class in admin
     *
     * @return mixed
     */

    public function getAllWhere($condition, $equals){ return $this->get('*', $condition, $equals); }


    /**
     * Basic delete
     *
     * @param array $by
     * @return mixed
     */

    public function delete(array $by){ return $this->database->delete($this->tableName, $by); }


    /**
     * Basic updater
     *
     * @param array $what
     * @param array $where
     * @return mixed
     */

    public function update(array $what, array $where){ return $this->database->update($this->tableName, $what, $where); }


    /**
     * Get's column headers for export
     *
     * @return array
     */

    public function getColumnHeaders()
    {
        $headers = array();
        foreach($this->database->get_col("DESC " . $this->tableName, 0) as $columnName){
            $headers[] = $columnName;
        }
        return $headers;
    }


    /**
     * Get's count
     *
     * @param null $condition
     * @param null $equals
     * @return mixed
     */

    public function count($condition = NULL, $equals = NULL)
    {
        if($condition && $equals){
            return $this->database->get_var("SELECT COUNT(*) AS count FROM $this->tableName WHERE $condition='$equals'");
        }
        return $this->database->get_var("SELECT COUNT(*) AS count FROM $this->tableName");
    }


    /**
     * Truncate
     *
     * @return mixed
     */

    public function truncate(){ return $this->database->query("TRUNCATE TABLE $this->tableName"); }


    /**
     * Goodie this one.
     *
     * @return mixed
     */


    final public static function getInstance()
    {
        static $instances = array();
        $calledClass = get_called_class();
        if(!isset($instances[$calledClass])){
            $instances[$calledClass] = new $calledClass();
        }
        return $instances[$calledClass];
    }
    final private function __clone(){}
}

class RepositaryException extends \Exception {}