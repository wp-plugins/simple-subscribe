<?php
/*
    Plugin Name: Simple Subscribe
    Description: The easiest to use subscribe plugin, just for you :)
    Author: latorante
    Author URI: http://latorante.name
    Author Email: martin@latorante.name
    Version: 1.0.8
    License: GPLv2
*/
/*
    Copyright 2013  Martin Picha  (email : martin@latorante.name)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('ABSPATH')) { exit; }

if (!class_exists('SimpleSubscribe'))
{
    class SimpleSubscribe
    {
        /** @var instance */
        protected static $instance;
        /** @var \SimpleSubscribeSettings */
        var $settings;


        /**
         * Constructor, does all this beautiful magic, loads all libs
         * registers all sorts of funky hooks, checks stuff and so on.
         */

        public function __construct()
        {
            // minimum requirements check
            require_once('classes/SimpleSubscribeCheck.php');
            SimpleSubscribeCheck::checkRequirements();
            // nette
            if(!defined('NETTE')){ require_once('classes/Nette.min.php'); }
            // required libs
            // TODO: autoload
            require_once('classes/Html2Text.php');
            require_once('classes/SimpleSubscribeUtils.php');
            require_once('classes/SimpleSubscribeCron.php');
            require_once('classes/SimpleSubscribeForms.php');
            require_once('classes/SimpleSubscribeEmail.php');
            require_once('classes/SimpleSubscribeTemplate.php');
            require_once('classes/SimpleSubscribeExporter.php');
            require_once('classes/SimpleSubscribeSettings.php');
            require_once('classes/SimpleSubscribeSubscribers.php');
            require_once('classes/SimpleSubscribeDevelopers.php');
            // wordpress related
            require_once('classes/SimpleSubscribeListTable.php');
            require_once('classes/SimpleSubscribeWidgets.php');
            require_once('classes/SimpleSubscribeShortcodes.php');
            require_once('classes/SimpleSubscribeFrontend.php');
            require_once('classes/SimpleSubscribeAdmin.php');
            require_once('SimpleSubscribeApi.php');
            // cosntants define
            define('SUBSCRIBE_KEY',     'simpleSubscribe');
            define('SUBSCRIBE_CRON',    'simple_subscribe_cron');
            define('SUBSCRIBE_HOME_URL',get_option('siteurl'));
            define('SUBSCRIBE_FOLDER',  plugins_url(NULL, __FILE__));
            define('SUBSCRIBE_ASSETS',  SUBSCRIBE_FOLDER . '/assets/');
            define('SUBSCRIBE_TEMPLATES',dirname(__FILE__) . DIRECTORY_SEPARATOR .'templates' . DIRECTORY_SEPARATOR);
            define('SUBSCRIBE_URL',     plugin_dir_url(__FILE__));
            define('SUBSCRIBE_PLUG',    dirname(plugin_basename(__FILE__)));
            define('SUBSCRIBE_REW',     'wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/');
            define('SUBSCRIBE_API_URL', SUBSCRIBE_HOME_URL . '/' . '?' . SUBSCRIBE_KEY);
            // activation / deactivation hooks
            register_activation_hook(__FILE__,      array($this, 'activate'));
            register_deactivation_hook( __FILE__,   array($this, 'deactivate'));
            // inits and cron
            add_action('init',                      array($this, 'init'));
            add_action('widgets_init', function(){ register_widget('SimpleSubscribeAddWidget'); });
            add_action('widgets_init', function(){ register_widget('SimpleSubscribeRemoveWidget'); });
            // settings
            $settings = new SimpleSubscribeSettings(SUBSCRIBE_KEY);
            $this->settings = $settings->getSettings();
            SimpleSubscribeShortcodes::register();
        }


        /**
         * Initialize
         */

        public function init()
        {
            /**
             * 1. Cron
             */

            add_action(SUBSCRIBE_CRON, array('SimpleSubscribeCron', 'cron'));


            /**
             * 2. Rewrite Rules
             */

            add_rewrite_rule(SUBSCRIBE_KEY . '/$', 'index.php?' . SUBSCRIBE_KEY, 'top');
            add_filter('query_vars', function($query_vars){
                $query_vars[] = SUBSCRIBE_KEY;
                $query_vars[] = 'a';    // subscribe confrim 'a'ction
                $query_vars[] = 'sb';   // user hash to be checked
                $query_vars[] = 'i';    // userId, to be checked against hash
                return $query_vars;
            });
            add_action('parse_request', function($wp){
                if(array_key_exists(SUBSCRIBE_KEY, $wp->query_vars)){
                    $api = new SimpleSubscribeApi($wp);
                }
            });


            /**
             * 3. Admin & Frontend
             */

            if(is_admin()){
                $admin = new SimpleSubscribeAdmin();
            } else {
                if($this->settings['val']['js'] == '1'){ add_action('wp_enqueue_scripts', function(){ wp_enqueue_script('netteForms', SUBSCRIBE_ASSETS . 'netteForms.js', array('jquery'), '1.0.0', TRUE); });  }
                if($this->settings['val']['css'] == '1'){ add_action('wp_enqueue_scripts', function(){ wp_enqueue_style('core', SUBSCRIBE_ASSETS . 'styleFrontEnd.css'); }); }
            }
        }


        /**
         * Activation hook
         */

        public static function activate()
        {
            // install
            global $wpdb;
            $tableName = strtolower($wpdb->prefix . 'subscribers');
            $tableDate = date('Y-m-d');
            if($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
                $sql = "CREATE TABLE " . $tableName . " (
                      id int(11) NOT NULL AUTO_INCREMENT,
                      active tinyint(1) default 0,
                      email varchar(120) NOT NULL,
                      firstName varchar(100) NOT NULL default '',
                      lastName varchar(120) NOT NULL default '',
                      age varchar(10) NOT NULL default '',
                      interests varchar(250) NOT NULL default '',
                      location varchar(250) NOT NULL default '',
                      date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      ip char(64) NOT NULL,
                      PRIMARY KEY (id)
                      );";
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);
            }
        }


        /**
         * Deactivation (captain) hook
         */

        public static function deactivate() { SimpleSubscribeCron::unscheduleCronEvents(); }


        /**
         * Goodie this one.
         *
         * @return SimpleSubscribe
         */

        final public static function getInstance()
        {
            static $instances = array();
            $calledClass = get_called_class();
            if (!isset($instances[$calledClass])){$instances[$calledClass] = new $calledClass();}
            return $instances[$calledClass];
        }
        final private function __clone(){}
    }
}

$simpleSubscribe = new SimpleSubscribe();