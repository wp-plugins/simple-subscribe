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

    /**
     * 1. Prepare tables to be deleted, go thru tables, check if they exist, and remove
     */

    $removeTables = array(
        $wpdb->prefix . "subscribers",
        $wpdb->prefix . "subscribers_log",
    );

    foreach($removeTables as $table){
        $wpdb->query("DROP TABLE IF EXISTS `" . $table . "`");
    }


    /**
     * 2. Delete simple subcribe options
     */

    delete_option('simpleSubscribe');


    /**
     * 3. Delete user meta
     */

    $registeredUsers = get_users(array('meta_key' => 'subscription', 'meta_value' => 1));
    if(!empty($registeredUsers)){
        foreach($registeredUsers as $user){
            delete_user_meta($user->data->ID, 'subscription');
            delete_user_meta($user->data->ID, 'subscribersPerPage');
        }
    }

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


