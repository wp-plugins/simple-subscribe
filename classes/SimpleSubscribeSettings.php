<?php
if (!defined('ABSPATH')) { exit; }

class SimpleSubscribeSettings extends Nette\Object
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

    public function getTiming(){ return isset($this->options['cron']['timing']) ? $this->options['cron']['timing'] : NULL; }


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
            'misc'  => array('deactivation' => '0', 'senderName' => html_entity_decode(get_option('blogname'), ENT_QUOTES), 'senderEmail' => get_option('admin_email')),
            'val'   => array('js' => '1', 'css' => '1'),
            'email' => array('type' => '1'),
            'emailDesign' => array(
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
}