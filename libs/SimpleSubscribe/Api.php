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

class Api
{
    /** @var \WP */
    var $request;
    /** @var array */
    var $messages = array();
    /** @var \SimpleSubscribe\Settings */
    var $settings;
    /** @var query vars */
    var $queryVars;


    /**
     * Constructor
     *
     * @param WP $request
     */

    public function __construct(\WP $request, \SimpleSubscribe\Settings $settings)
    {
        $this->request = $request;
        $this->queryVars = $this->request->query_vars;
        $this->settings = $settings;
        $this->process();
    }


    /**
     * Process actions
     */

    public function process()
    {
        if(isset($this->queryVars['a']) && ($this->queryVars['a'] == 's')){
            if((isset($this->queryVars['sb']) && !empty($this->queryVars['sb'])) && (isset($this->queryVars['i']) && !empty($this->queryVars['i']))){
                try {
                    $subscribers = \SimpleSubscribe\RepositorySubscribers::getInstance();
                    $subscribers->validateApiCall($this->queryVars['i'], $this->queryVars['sb']);
                    $subscribers->activateUser($this->queryVars['i']);
                    $this->addMessage('success', 'Congratulations! You\'ve successfully subscribed!');
                } catch (RepositarySubscribersException $e){
                    $this->addMessage('error', $e->getMessage());
                }
            }
        }
        $this->display();
    }


    /**
     * Display the whole thang
     *
     * @param array $data
     */

    public function display($data = array())
    {
        $template = new \SimpleSubscribe\Template('adminApi.latte');
        $templateGuts = $this->hasMessages() ? $this->getMessages() : \SimpleSubscribe\FrontEnd::unsubscriptionForm();
        $templateAction = $this->hasMessages() ? 'Confirm Subscription' : 'Unsubscribe';
        $templateBackUrl = $this->settings->getBackLinkUrl();

        $defaults = array(
            'action' => $templateAction,
            'stylesheetUrl' => SUBSCRIBE_ASSETS . 'styleApi.css',
            'guts' => $templateGuts,
            'backLink' => '<a href="' . $templateBackUrl . '">Back to homepage &raquo;</a>'
        );
        $template->prepareTemplate($defaults, $data);
        echo $template->getTemplate();
    }


    /**
     * Just debug thing
     */

    public function getMessages()
    {
        $output = '';
        foreach($this->messages as $value){
            $output .= '<span class="'. $value[0] .'">' . $value[1] . '</span>';
        }
        return $output;
    }


    /**
     * Checks notices
     *
     * @return bool
     */

    public function hasMessages()
    {
        if(!empty($this->messages)){
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Add notices
     *
     * @param $key
     * @param $value
     */

    private function addMessage($key,$value)
    {
        $this->messages[] = array($key,$value);
    }


    /**
     * Destructor just kills it, before wordpress does his shenanigans
     */

    public function __destruct(){ exit(); }
}