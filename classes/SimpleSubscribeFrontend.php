<?php
if (!defined('ABSPATH')) { exit; }


class SimpleSubscribeFrontEnd
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
        $widgetId = isset($args['widget_id']) ? $args['widget_id'] : NULL;
        $settings = new SimpleSubscribeSettings(SUBSCRIBE_KEY);
        $form = SimpleSubscribeForms::subscriptionForm($settings->getTableColumns(), $widget, $widgetId);

        if ($form->isSubmitted() && $form->isValid()){
            try{
                $subscribers = SimpleSubscribeSubscribers::getInstance();
                $subscribers->add($form->getValues());
                $widgetMessage = '<strong>Thank you for your subscription!</strong> Confirmation e-mail was sent to your e-mail address!';
                $form->setValues(array(),TRUE);
            } catch (SubscribersException $e){
                $form->addError($e->getMessage());
            }
        }

        if($widget){
            // defaults
            $defaults = array(
                'beforeWidget' => $args['before_widget'],
                'beforeTitle' => $args['before_title'],
                'afterTitle' => $args['after_title'],
                'widgetTitle' => 'Subscribe',
                'message' => $widgetMessage,
                'guts' => $form,
                'afterWidget' => $args['after_widget'],
            );
            // template
            $template = new SimpleSubscribeTemplate('widget.latte');
            $template->prepareTemplate($defaults);
        } else {
            // defaults
            $defaults = array(
                'title' => 'Subscribe',
                'message' => $widgetMessage,
                'guts' => $form
            );
            // template
            $template = new SimpleSubscribeTemplate('shortcode.latte');
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
        $widgetId = isset($args['widget_id']) ? $args['widget_id'] : NULL;
        $form = SimpleSubscribeForms::unsubscriptionForm($widget, $widgetId);
        if ($form->isSubmitted() && $form->isValid()){
            try {
                $subscribers = SimpleSubscribeSubscribers::getInstance();
                $formValues = $form->getValues();
                $subscribers->deleteOrDeactivateByEmail($formValues->email);
                $widgetMessage = '<strong>You have successfully unsubscribed. We\'re sorry to see you leave!</strong>';
                $form = '';
            } catch (SubscribersException $e){
                $form->addError($e->getMessage());
            }
        }
        if($widget){
            // defaults
            $defaults = array(
                'beforeWidget' => $args['before_widget'],
                'beforeTitle' => $args['before_title'],
                'afterTitle' => $args['after_title'],
                'widgetTitle' => 'Unsubscribe',
                'message' => $widgetMessage,
                'guts' => $form,
                'afterWidget' => $args['after_widget'],
            );
            // template
            $template = new SimpleSubscribeTemplate('widget.latte');
            $template->prepareTemplate($defaults);
        } else {
            // defaults
            $defaults = array(
                'title' => 'Unsubscribe',
                'message' => $widgetMessage,
                'guts' => $form
            );
            // template
            $template = new SimpleSubscribeTemplate('shortcode.latte');
            $template->prepareTemplate($defaults);
        }
        return $template->getTemplate();
    }

}
