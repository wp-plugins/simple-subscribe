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


class Utils
{
    /** time constant used with cron */
    const NINE_AM = '9AM UTC';
    /** time constant used with cron */
    const NINE_PM = '9PM UTC';


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


    /**
     * Posts page url
     *
     * @return null
     */

    public static function getPostsPageUrl()
    {
        $a = get_option('page_for_posts');
        if(!empty($a)){
            return get_permalink((int)$a);
        }
        return NULL;
    }


    /**
     * Little helper for e-mail body
     *
     * @param $id
     * @return mixed|null
     */

    public static function getPostContent($id)
    {
        if(!is_numeric($id) || empty($id)){
            return NULL;
        }
        return str_replace(']]>', ']]>', apply_filters('the_content', get_post($id)->post_content));
    }


    /**
     * Does what it says, converts camel case to underscore
     *
     * @param $string
     * @return string
     */

    public static function camelCaseToUnderscore($string){ return strtolower(preg_replace('/(?!^)[[:upper:]]/','_\0', $string)); }


    /**
     * String to udnerscore
     *
     * @param $string
     * @return string
     */

    public static function toUnderscore($string){ return strtolower(preg_replace('/([a-z])([A-Z])/','$1_$2', $string)); }
}