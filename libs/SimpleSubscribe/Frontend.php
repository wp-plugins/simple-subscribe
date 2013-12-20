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


class FrontEnd
{
    /**
     * Subscriptino form
     *
     * @param bool $widget
     * @param array $args
     * @return Nette\Templating\FileTemplate
     */

    public static function subscriptionForm($widget = FALSE, $args = array())
    {
        $widgetMessage = '';
        $widgetTitle = (isset($args['title']) && !empty($args['title'])) ? $args['title'] : 'Subscribe';
        $widgetId = isset($args['widget_id']) ? $args['widget_id'] : NULL;
        $settings = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
        $form = \SimpleSubscribe\Forms::subscriptionForm($settings->getTableColumns(), $widget, $widgetId);

        if ($form->isSubmitted() && $form->isValid()){
            try{
                $subscribers = \SimpleSubscribe\RepositorySubscribers::getInstance();
                $subscribers->add($form->getValues());
                $widgetMessage = '<strong>Thank you for your subscription!</strong> Confirmation e-mail was sent to your e-mail address!';
                $form->setValues(array(),TRUE);
            } catch (RepositarySubscribersException $e){
                $form->addError($e->getMessage());
            }
        }

        if($widget){
            // defaults
            $defaults = array(
                'beforeWidget' => $args['before_widget'],
                'beforeTitle' => $args['before_title'],
                'afterTitle' => $args['after_title'],
                'widgetTitle' => $widgetTitle,
                'message' => $widgetMessage,
                'guts' => $form,
                'afterWidget' => $args['after_widget'],
            );
            // template
            $template = new \SimpleSubscribe\Template('widget.latte');
            $template->prepareTemplate($defaults);
        } else {
            // defaults
            $defaults = array(
                'title' => 'Subscribe',
                'message' => $widgetMessage,
                'guts' => $form
            );
            // template
            $template = new \SimpleSubscribe\Template('shortcode.latte');
            $template->prepareTemplate($defaults);
        }

        return $template->getTemplate();
    }


    /**
     * Unsubscription form
     *
     * @param bool $widget
     * @param array $args
     * @return Nette\Templating\FileTemplate
     */

    public static function unsubscriptionForm($widget = FALSE, $args = array())
    {
        $widgetMessage = '';
        $widgetTitle = (isset($args['title']) && !empty($args['title'])) ? $args['title'] : 'Unsubscribe';
        $widgetId = isset($args['widget_id']) ? $args['widget_id'] : NULL;
        $form = \SimpleSubscribe\Forms::unsubscriptionForm($widget, $widgetId);
        if ($form->isSubmitted() && $form->isValid()){
            try {
                $subscribers = \SimpleSubscribe\RepositorySubscribers::getInstance();
                $formValues = $form->getValues();
                $subscribers->deleteOrDeactivateByEmail($formValues->email);
                $widgetMessage = '<strong>You have successfully unsubscribed. We\'re sorry to see you leave!</strong>';
                $form = '';
            } catch (RepositarySubscribersException $e){
                $form->addError($e->getMessage());
            }
        }
        if($widget){
            // defaults
            $defaults = array(
                'beforeWidget' => $args['before_widget'],
                'beforeTitle' => $args['before_title'],
                'afterTitle' => $args['after_title'],
                'widgetTitle' => $widgetTitle,
                'message' => $widgetMessage,
                'guts' => $form,
                'afterWidget' => $args['after_widget'],
            );
            // template
            $template = new \SimpleSubscribe\Template('widget.latte');
            $template->prepareTemplate($defaults);
        } else {
            // defaults
            $defaults = array(
                'title' => 'Unsubscribe',
                'message' => $widgetMessage,
                'guts' => $form
            );
            // template
            $template = new \SimpleSubscribe\Template('shortcode.latte');
            $template->prepareTemplate($defaults);
        }
        return $template->getTemplate();
    }

}
