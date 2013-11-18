<?php
if (!defined('ABSPATH')) { exit; }

class SimpleSubscribeApi
{
    /** @var \WP */
    var $request;
    /** @var array */
    var $messages = array();
    /** @var query vars */
    var $queryVars;


    /**
     * Loads wp, sets request
     *
     * @param $get
     */

    public function __construct(WP $request)
    {
        $this->request = $request;
        $this->queryVars = $this->request->query_vars;
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
                    $subscribers = SimpleSubscribeSubscribers::getInstance();
                    $subscribers->validateApiCall($this->queryVars['i'], $this->queryVars['sb']);
                    $subscribers->activateUser($this->queryVars['i']);
                    $this->addMessage('success', 'Congratulations! You\'ve succesfully subsribed!');
                } catch (SubscribersException $e){
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
        $template = new SimpleSubscribeTemplate('adminApi.latte');
        $templateGuts = $this->hasMessages() ? $this->getMessages() : SimpleSubscribeFrontEnd::unsubscriptionForm();
        $templateAction = $this->hasMessages() ? 'Confirm Subscription' : 'Unsubscribe';
        $defaults = array(
            'action' => $templateAction,
            'stylesheetUrl' => SUBSCRIBE_ASSETS . 'styleApi.css',
            'guts' => $templateGuts,
            'backLink' => '<a href="' . SUBSCRIBE_HOME_URL . '">Back to homepage &raquo;</a>'
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