<?php
if (!defined('ABSPATH')) { exit; }

use Nette\Templating\FileTemplate,
    Nette\Latte,
    Nette\Latte\Engine;

class SimpleSubscribeTemplate extends Nette\Object
{
    /** @var \Nette\Templating\FileTemplate */
    var $template;


    /**
     * Constructor
     *
     * @param $templateName
     */

    public function __construct($templateName)
    {
        $this->template = new Nette\Templating\FileTemplate(SUBSCRIBE_TEMPLATES . $templateName);
        $this->template->registerFilter(new Nette\Latte\Engine);
        $this->template->registerHelperLoader('Nette\Templating\Helpers::loader');
    }


    /**
     * Prepare template values
     *
     * @param array $defaults
     * @param array $data
     */

    public function prepareTemplate($defaults = array(), $data = array())
    {
        if(!empty($defaults) && is_array($defaults)){
            foreach($defaults as $key => $value){
                $this->template->$key = $value;
            }
        }
        if(!empty($data) && is_array($data)){
            foreach($data as $key => $value){
                $this->template->$key = $value;
            }
        }
    }


    /**
     * Returns ready template
     *
     * @return Nette\Templating\FileTemplate
     */

    public function getTemplate(){ return $this->template; }
}

class TemplateException extends Exception{}