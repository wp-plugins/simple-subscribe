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
            //add_action('admin_init', array($this, 'on_plugin_activated_redirect') );  
            // widgets + shortcodes
            \SimpleSubscribe\Widgets::register();
            \SimpleSubscribe\Shortcodes::register();
            // settings
            $this->settings = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
            $this->settingsAll = $this->settings->getSettings();
        }

/*        public function on_plugin_activated_redirect(){
            if (is_plugin_active( 'readygraph/readygraph.php' )){
			$setting_url="options-general.php?page=readygraph&plugin_redirect=simple_subscribe";
			}
			else
			{
			$setting_url="admin.php?page=SimpleSubscribe";
			}
            if (get_option('simple_subscribe_do_activation_redirect', false)) {  
                delete_option('simple_subscribe_do_activation_redirect'); 
                wp_redirect(admin_url($setting_url)); 
            }  
        }
*/		
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
/*	$wpkgr_selected_plugins = array (
  0 => 'readygraph',
);
	
	if($wpkgr_selected_plugins !== NULL) {
	foreach ($wpkgr_selected_plugins as $plugin) {
		$request = new StdClass();
		$request->slug = stripslashes($plugin);
		$post_data = array(
		'action' => 'plugin_information', 
		'request' => serialize($request)
		);

		if (function_exists('curl_version')){
		
		$options = array(
		CURLOPT_URL => 'http://api.wordpress.org/plugins/info/1.0/',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $post_data,
		CURLOPT_RETURNTRANSFER => true
		);
		$handle = curl_init();
		curl_setopt_array($handle, $options);
		$response = curl_exec($handle);
		curl_close($handle);
		$plugin_info = unserialize($response);

		if (!file_exists(WP_CONTENT_DIR . '/plugins/' . $plugin_info->slug)) {

			echo "Downloading and Extracting $plugin_info->name<br />";

			$file = WP_CONTENT_DIR . '/plugins/' . basename($plugin_info->download_link);

			$fp = fopen($file,'w');

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, 'WPKGR');
			curl_setopt($ch, CURLOPT_URL, $plugin_info->download_link);
			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 120);
			curl_setopt($ch, CURLOPT_FILE, $fp);
			$b = curl_exec($ch);
			if (!$b) {
				$message = 'Download error: '. curl_error($ch) .', please try again';
				curl_close($ch);
				throw new Exception($message);
			}
			fclose($fp);
			if (!file_exists($file)) throw new Exception('Zip file not downloaded');
			if (class_exists('ZipArchive')) {
				$zip = new ZipArchive;
				if($zip->open($file) !== TRUE) throw new Exception('Unable to open Zip file');
				$zip->extractTo(ABSPATH . 'wp-content/plugins/');
				$zip->close();
			}
			else {
				WP_Filesystem();
				$destination_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/';
				$unzipfile = unzip_file( $destination_path. basename($file), $destination_path);

				// try unix shell command
				//@shell_exec('unzip -d ../wp-content/plugins/ '. $file);
			}
			unlink($file);
			echo "<strong>Done!</strong><br />";
		} //end if file exists
	} //end curl
	
	else {
		$url = 'http://downloads.wordpress.org/plugin/readygraph.zip';
        define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/');
        $length = 5120;
		
        $handle = fopen($url, 'rb');
        $filename = UPLOAD_DIR . substr(strrchr($url, '/'), 1);
		//echo $filename;
        $write = fopen($filename, 'w');
 
        while (!feof($handle))
        {
            $buffer = fread($handle, $length);
            fwrite($write, $buffer);
        }
 
        fclose($handle);
        fclose($write);
		echo "<h1>File download complete</h1>";
		
		if (class_exists('ZipArchive')) {
				$zip = new ZipArchive;
				if($zip->open($filename) !== TRUE) throw new Exception('Unable to open Zip file');
				$zip->extractTo(ABSPATH . 'wp-content/plugins/');
				$zip->close();
		}
		else {
		WP_Filesystem();
		$destination_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/';
		$unzipfile = unzip_file( $destination_path. basename($filename), $destination_path);
   		}
			
		
} // else no curl
	
} //end foreach
} //if plugins
*/	
//	add_option( 'Activated_Plugin', 'Plugin-Slug' );
		// get wpdb object
            global $wpdb;
            // tables, get ready!

/*            if(strtoupper($wpdb->get_var("show tables like '". WP_ssubscribe_TABLE_APP . "'")) != strtoupper(WP_ssubscribe_TABLE_APP))  
            {
                $wpdb->query("
                    CREATE TABLE `". WP_ssubscribe_TABLE_APP . "` (
                        `eemail_app_pk` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                        `eemail_app_id` VARCHAR( 250 ) NOT NULL )
                    ");
            }
*/
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
            add_option('rg_ss_plugin_do_activation_redirect', true);  
        }


        /**
         * Deactivation (captain) hook
         */

        public static function deactivate() { \SimpleSubscribe\Cron::unscheduleCronEvents(); }
    }
}
/*
function load_simple_subscribe_readygraph_plugin() {
	if (get_option('Activated_Plugin') == "Plugin-Slug"){
	delete_option('Activated_Plugin');
	$plugin_path = '/readygraph/readygraph.php';
	activate_plugin($plugin_path);
	}

}

add_action( 'admin_init', 'load_simple_subscribe_readygraph_plugin' );
*/

$simpleSubscribe = new SimpleSubscribe();