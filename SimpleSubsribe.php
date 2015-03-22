<?php
/*
    Plugin Name: Simple Subscribe
    Description: The easiest to use subscribe plugin, just for you :)
    Author: latorante, tanaylakhani
    Author URI: http://latorante.name
    Author Email: martin@latorante.name
    Version: 1.8.2
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

/**
 * 1. If no Wordpress, go home
 */
global $wpdb, $wp_version;
if (!defined('ABSPATH')) { exit; }
//define("WP_ssubscribe_TABLE_APP", $wpdb->prefix . "ssubscribe_app");

/**
 * 2. Check minimum requirements (wp version, php version)
 * Reason behind this is, we just need PHP 5.3.1 at least,
 * and wordpress 3.3 or higher. We just can't run the show
 * on some outdated installation.
 */

require_once('SimpleSubscribeCheck.php');
SimpleSubscribeCheck::checkRequirements();

/**
 * 3. Activation / deactivation
 */

register_activation_hook(__FILE__,      array('SimpleSubscribe', 'activate'));
register_deactivation_hook( __FILE__,   array('SimpleSubscribe', 'deactivate'));

/**
 * 4. Go, and do Simple Subscribe!
 */
function ss_rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           ss_rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
  $del_url = plugin_dir_path( __FILE__ );
  unlink($del_url.'/readygraph-extension.php');
 $setting_url="admin.php?page=SimpleSubscribe";
  echo'<script> window.location="'.admin_url($setting_url).'"; </script> ';
}
function ss_delete_rg_options() {
delete_option('readygraph_access_token');
delete_option('readygraph_application_id');
delete_option('readygraph_refresh_token');
delete_option('readygraph_email');
delete_option('readygraph_settings');
delete_option('readygraph_delay');
delete_option('readygraph_enable_sidebar');
delete_option('readygraph_auto_select_all');
delete_option('readygraph_enable_notification');
delete_option('readygraph_enable_branding');
delete_option('readygraph_send_blog_updates');
delete_option('readygraph_send_real_time_post_updates');
delete_option('readygraph_popup_template');
}
require_once('SimpleSubscribeInit.php');
if( file_exists(plugin_dir_path( __FILE__ ).'/readygraph-extension.php' )) {
	include "readygraph-extension.php";
}
else {

}