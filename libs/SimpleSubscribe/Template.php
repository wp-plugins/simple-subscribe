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

use Nette\Templating\FileTemplate,
    Nette\Latte,
    Nette\Latte\Engine;


class Template extends \Nette\Object
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
        $this->template = new \Nette\Templating\FileTemplate(SUBSCRIBE_TEMPLATES . $templateName);
        $this->template->registerFilter(new \Nette\Latte\Engine);
        $this->template->registerHelperLoader('\Nette\Templating\Helpers::loader');
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

class TemplateException extends \Exception{}