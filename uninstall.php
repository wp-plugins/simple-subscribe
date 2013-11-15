<?php

/**
 * Wordpress core & uninstall check
 */

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')){ exit(); }

/**
 * Uninstall function
 */

function simpleSubscribeUninstall()
{
    global $wpdb;
    $public = $wpdb->prefix . "subscribers";
    $sql = "DROP TABLE IF EXISTS `" . $public . "`";
    $wpdb->query($sql);
    delete_option('simpleSubscribe');
}


/**
 * Go Go Go!
 */

if (function_exists('is_multisite') && is_multisite()){
    global $wpdb;
    $blogs = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
    foreach ($blogs as $blog){
        switch_to_blog($blog);
        simpleSubscribeUninstall();
        restore_current_blog();
    }
} else {
    simpleSubscribeUninstall();
}


