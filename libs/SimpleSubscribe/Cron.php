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


class Cron
{
    /**
     * Run Cron
     */

    public static function cron()
    {
        $data = func_get_args();
        if(is_numeric($data[0])){ // let's assume this is post ID right
            $post = get_post($data[0]);
            if(!empty($post)){
                \SimpleSubscribe\Email::getInstance()->onPublish($post);
            }
        }
    }


    /**
     * Schedule Cron Event
     *
     * @param null $time
     * @param $postId
     */

    public static function scheduleCron($time, $postId)
    {
        wp_schedule_single_event(\SimpleSubscribe\Utils::closestTime($time), SUBSCRIBE_CRON, array($postId));
    }


    /**
     * Clears out given hook
     *
     * @param string $hookName
     */

    public static function unscheduleCronEvents($hookName = SUBSCRIBE_CRON)
    {
        $events = get_option('cron');
        error_reporting(0);
        if(!empty($events)){
            foreach($events as $time => $cron){
                if(!empty($cron)){
                    foreach($cron as $hook => $dings){
                        if($hook == $hookName){
                            foreach($dings as $sig => $data){
                                wp_unschedule_event($time, $hook, $data['args']);
                            }
                        }
                    }
                }
            }
        }
    }
}