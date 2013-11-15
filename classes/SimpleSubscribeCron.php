<?php
if (!defined('ABSPATH')) { exit; }

class SimpleSubscribeCron
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
                SimpleSubscribeEmail::getInstance()->onPublish($post);
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
        wp_schedule_single_event(SimpleSubscribeUtils::closestTime($time), SUBSCRIBE_CRON, array($postId));
    }


    /**
     * Clears out given hook
     *
     * @param string $hookName
     */

    public static function unscheduleCronEvents($hookName = SUBSCRIBE_CRON)
    {
        $events = get_option('cron');
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