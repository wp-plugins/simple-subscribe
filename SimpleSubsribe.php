<?php
/*
    Plugin Name: Simple Subscribe
    Description: The easiest to use subscribe plugin, just for you :)
    Author: latorante
    Author URI: http://latorante.name
    Author Email: martin@latorante.name
    Version: 1.1.4.2
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
        /** @var \SimpleSubscribe\Settings */
        var $settings;
        /** @var All settings as an array */
        var $settingsAll;


        /**
         * Constructor, does all this beautiful magic, loads all libs
         * registers all sorts of funky hooks, checks stuff and so on.
         */

        public function __construct()
        {
            // minimum requirements check
            require_once('SimpleSubscribeCheck.php');
            SimpleSubscribeCheck::checkRequirements();
            // nette, nope, we're not going without you brother
            if(!defined('NETTE')){ require_once('libs/Nette/Nette.min.php'); }
            // If debugging is the process of removing bugs, then programming must be the process of putting them in. - Edsger W. Dijkstra
            //\Nette\Diagnostics\Debugger::$productionMode = FALSE;
            //\Nette\Diagnostics\Debugger::enable();
            // required libs
            $robotLoader = new \Nette\Loaders\RobotLoader();
            $robotLoader->addDirectory(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR);
            $robotLoader->setCacheStorage(new \Nette\Caching\Storages\MemoryStorage);
            $robotLoader->register();
            // cosntants define
            define('SUBSCRIBE_KEY',     'simpleSubscribe');
            define('SUBSCRIBE_CRON',    'simple_subscribe_cron');
            define('SUBSCRIBE_HOME_URL',get_option('siteurl'));
            define('SUBSCRIBE_FOLDER',  plugins_url(NULL, __FILE__));
            define('SUBSCRIBE_ASSETS',  SUBSCRIBE_FOLDER . '/assets/');
            define('SUBSCRIBE_TEMPLATES',dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR);
            define('SUBSCRIBE_API_URL', SUBSCRIBE_HOME_URL . '/' . '?' . SUBSCRIBE_KEY);
            // activation / deactivation hooks
            register_activation_hook(__FILE__,      array($this, 'activate'));
            register_deactivation_hook( __FILE__,   array($this, 'deactivate'));
            // init
            add_action('init',                      array($this, 'init'));
            // widgets + shortcodes
            add_action('widgets_init', function(){ register_widget('\SimpleSubscribe\WidgetAdd'); });
            add_action('widgets_init', function(){ register_widget('\SimpleSubscribe\WidgetRemove'); });
            \SimpleSubscribe\Shortcodes::register();
            // settings
            $this->settings = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
            $this->settingsAll = $this->settings->getSettings();
        }


        /**
         * Initialize
         */

        public function init()
        {
            /** 1. Cron */
            add_action(SUBSCRIBE_CRON, array('\SimpleSubscribe\Cron', 'cron'));

            /** 2. Rewrite Rules */
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
                    $api = new \SimpleSubscribe\Api($wp);
                }
            });

            /** 3. Admin & Frontend */
            if(is_admin()){
                $admin = new \SimpleSubscribe\Admin();
            } else {
                if(isset($this->settingsAll['val']['js'])){
                    if($this->settingsAll['val']['js'] == '1'){
                        add_action('wp_enqueue_scripts', function(){ wp_enqueue_script('netteForms', SUBSCRIBE_ASSETS . 'netteForms.js', array('jquery'), '1.0.0', TRUE); });
                    }
                }
                if(isset($this->settingsAll['val']['css']) == '1'){
                    if($this->settingsAll['val']['css'] == '1'){
                        add_action('wp_enqueue_scripts', function(){ wp_enqueue_style('core', SUBSCRIBE_ASSETS . 'styleFrontEnd.css'); });
                    }
                }
            }
        }


        /**
         * Activation hook
         */

        public static function activate()
        {
            // get wpdb object
            global $wpdb;
            // tables, get ready!
            $tables = array(
                strtolower($wpdb->prefix . 'subscribers') =>
                    "CREATE TABLE " . strtolower($wpdb->prefix . 'subscribers') . " (
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
                    );",
                strtolower($wpdb->prefix . 'subscribers_log') =>
                    "CREATE TABLE " . strtolower($wpdb->prefix . 'subscribers_log') . " (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    type tinyint(1) default 0,
                    message varchar(250) NOT NULL default '',
                    PRIMARY KEY (id)
                    );",
            );

            // go thru
            foreach($tables as $table => $sql){
                if($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table){
                    // table doesn't exist, let's create it
                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    dbDelta($sql);
                }
            }
        }


        /**
         * Deactivation (captain) hook
         */

        public static function deactivate() { \SimpleSubscribe\Cron::unscheduleCronEvents(); }
    }
}

$simpleSubscribe = new SimpleSubscribe();