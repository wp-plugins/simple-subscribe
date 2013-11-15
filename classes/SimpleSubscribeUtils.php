<?php

if (!defined('ABSPATH')) { exit; }

class SimpleSubscribeUtils
{
    /** time constant used with cron */
    const NINE_AM = '9AM UTC';
    /** time constant used with cron */
    const NINE_PM = '11PM UTC';


    /**
     * Checks postType, very handy sometimes
     *
     * @param $type
     * @return bool
     */

    public static function isPostType($type)
    {
        global $wp_query;
        if ($type == get_post_type($wp_query->post->ID)) return true;
        return false;
    }


    /*
     * Real IP innit.
     */

    public static function getRealIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }


    /**
     * Is wp using permalinks?
     *
     * @return bool
     */

    public static function usingPermalinks()
    {
        global $wp_rewrite;
        if ($wp_rewrite->permalink_structure == ''){
            return FALSE;
        }
        return TRUE;
    }


    /**
     * Better than nothing folks.
     *
     * @param $time
     * @return int
     */

    public static function closestTime($time)
    {
        switch($time){
            case self::NINE_AM:
                if (date('G', time()) >= 9){
                    return strtotime("+1 day" . self::NINE_AM);
                }
                return strtotime(self::NINE_AM);
                break;
            case self::NINE_PM:
            default:
                if (date('G', time()) >= 23){
                    return strtotime("+1 day" . self::NINE_PM);
                }
                return strtotime(self::NINE_PM);
                break;
        }
    }
}