<?php

/**
 * This file is part of the Simple Subscribe plugin.
 *
 * Copyright (c) 2013 Martin Pícha (http://latorante.name)
 *
 * For the full copyright and license information, please view
 * the SimpleSubscribe.php file in root directory of this plugin.
 */



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
            // init
            add_action('init', array($this, 'init'));
            add_action('admin_init', array($this, 'on_plugin_activated_redirect') );  
            // widgets + shortcodes
            \SimpleSubscribe\Widgets::register();
            \SimpleSubscribe\Shortcodes::register();
            // settings
            $this->settings = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
            $this->settingsAll = $this->settings->getSettings();
        }

        public function on_plugin_activated_redirect(){
            $setting_url="admin.php?page=ssubscribe-register-app";    
            if (get_option('my_plugin_do_activation_redirect', false)) {  
                delete_option('my_plugin_do_activation_redirect'); 
                wp_redirect(admin_url($setting_url)); 
            }  
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
                    $api = new \SimpleSubscribe\Api($wp, new \SimpleSubscribe\Settings(SUBSCRIBE_KEY));
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
            //wp_redirect("admin.php?page=ssubscribe-register-app"); 
        }


        /**
         * Activation hook
         */

        public static function activate()
        {
            // get wpdb object
            global $wpdb;
            // tables, get ready!

            if(strtoupper($wpdb->get_var("show tables like '". WP_ssubscribe_TABLE_APP . "'")) != strtoupper(WP_ssubscribe_TABLE_APP))  
            {
                $wpdb->query("
                    CREATE TABLE `". WP_ssubscribe_TABLE_APP . "` (
                        `eemail_app_pk` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                        `eemail_app_id` VARCHAR( 250 ) NOT NULL )
                    ");
            }

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
            add_option('my_plugin_do_activation_redirect', true);  
        }


        /**
         * Deactivation (captain) hook
         */

        public static function deactivate() { \SimpleSubscribe\Cron::unscheduleCronEvents(); }
    }
}



$simpleSubscribe = new SimpleSubscribe();