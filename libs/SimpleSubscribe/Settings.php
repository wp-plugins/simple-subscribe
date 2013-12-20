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


class Settings extends \Nette\Object
{
    /** @var master key */
    var $key;
    /** @var mixed */
    var $options;


    /**
     * Constructor
     *
     * @param $key
     */

    public function __construct($key)
    {
        $this->key = $key;
        $this->options = $this->getSettings();
        $this->init();
    }


    /**
     * Init, checks if settings exists, if not, fills ine defaults
     */

    public function init()
    {
        if(empty($this->options)){
            $this->saveSettings($this->getDefaults());
        }
    }


    /**
     * Get settings
     *
     * @return mixed
     */

    public function getSettings()
    {
        $settings = unserialize(get_option($this->key));
        $settingsMerge = is_array($settings) ? $settings : array();
        return $settingsMerge;
    }


    /**
     * Get Timing settings
     *
     * @return mixed
     */

    public function getTiming(){ return isset($this->options['cron']['timing']) ? $this->options['cron']['timing'] : 0; }


    /**
     * Get's categories
     *
     * @return array
     */

    public function getCategories(){ return isset($this->options['cat']) ? $this->options['cat'] : array('0' => TRUE); }


    /**
     * Get's array of cat ids, to test
     * with current post cats
     *
     * @return array
     */

    public function getArrayCategories()
    {
        $arr = array();
        foreach($this->getCategories() as $key => $value){
            if(0 != $key){
               $arr[] = $key;
            }
        }
        return $arr;
    }


    /**
     * In category, can we post?
     *
     * @param $post
     * @return bool
     */

    public function inCategory($post)
    {
        // get vars
        $categories = $this->getCategories();
        $catogoriesAllowed = $this->getArrayCategories();
        $categoriesPost = wp_get_post_categories($post->ID);

        if(isset($categories['0']) && $categories['0'] == TRUE){
            return TRUE;
        }
        foreach($categoriesPost as $cat){
            if(array_key_exists($cat, $categories)){
                return TRUE;
            }
        }
        return FALSE;
    }


    /**
     * Get's log status
     *
     * @return bool
     */

    public function getLogStatus(){ return isset($this->options['misc']['log']) ? TRUE : FALSE; }


    /**
     * Backbutton homepage link
     *
     * @return null
     */

    public function getBackLinkUrl()
    {
        $postsPage = \SimpleSubscribe\Utils::getPostsPageUrl();
        $postsPageSettings = isset($this->options['misc']['homeUrl']) ? TRUE : FALSE;
        if($postsPageSettings){
            return $postsPage;
        }
        return SUBSCRIBE_HOME_URL;
    }


    /**
     * Save settings
     *
     * @param $array
     * @return mixed
     */

    public function saveSettings($array){ return update_option($this->key, serialize(array_filter(array_map('array_filter', array_merge($this->getSettings(), $array))))); }


    /**
     * Settings default
     *
     * @return array
     */

    public function getDefaults()
    {
        return array(
            'cron'  => array('timing' => '0'),
            'misc'  => array(
                'deactivation' => '0',
                'senderName' => html_entity_decode(get_option('blogname'), ENT_QUOTES),
                'senderEmail' => get_option('admin_email'),
                'log' => '1'
            ),
            'val'   => array('js' => '1', 'css' => '1'),
            'email' => array('type' => '1'),
            'cat'   => array('0' => '1'),
            'emailDesign' => array(
                'colourBodyBg' => '#ececec',
                'colourBg' => '#f5f5f5',
                'colourTitle' => '#000000',
                'colourLinks' => '#000000'),
            'emailType' => (array('source' => '0', 'type' => '1'))
        );
    }


    /**
     * Default columns
     *
     * @return mixed
     */

    public function getTableColumns()
    {
        $return = array();
        $formFieldsKeys = $this->getFormFieldsKeys();
        if(isset($this->options['form'])){
            foreach($this->options['form'] as $key => $value){
                if($value == '1'){
                    $return[$key] = $formFieldsKeys[$key];
                }
            }
        }
        return $return;
    }


    /**
     * Form fields keys
     *
     * @return array
     */

    public function getFormFieldsKeys()
    {
        return array(
            'firstName' => 'First Name',
            'lastName'  => 'Last Name',
            'interests' => 'Interests',
            'age'       => 'Age',
            'location'  => 'Location'
        );
    }


    /**
     * Get's social services
     *
     * @return array
     */

    public static function getSocialServices()
    {
        return array(
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'pinterest' => 'Pinterest',
            'youtube' => 'Youtube',
            'vimeo' => 'Vimeo',
            'google' => 'Google Plus+',
            'tumblr' => 'Tumblr',
            'flickr' => 'Flickr',
        );
    }
}