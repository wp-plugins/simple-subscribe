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
        $under_style = 'none';
        $has_app = false;

        global $wpdb;
/*        $cSql = "select * from wp_ssubscribe_app where 1=1 ";
        $data = $wpdb->get_results($cSql,ARRAY_A);
        if(count($data) > 0){
            $has_app =true;
            $under_style = 'inherit';
        }
*/
		$readygraph_api = get_option('readygraph_application_id');
		if ($readygraph_api && strlen($readygraph_api) > 0) {
			$has_app =true;
            $under_style = 'inherit';
		}
        if ($form->isSubmitted() && $form->isValid()){
            try{
                $subscribers = \SimpleSubscribe\RepositorySubscribers::getInstance();
                $subscribers->add($form->getValues());

                if($has_app){
                    $email = $form->getValues()->email;
					 $app_id = get_option('readygraph_application_id');
                    $rg_url = 'https://readygraph.com/api/v1/wordpress-enduser/';

                    $postdata = http_build_query(
                        array(
                            'email' => $email,
                            'app_id' => $app_id
                        )
                    );

                    $opts = array('http' =>
                        array(
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded',
                            'content' => $postdata
                        )
                    );
                    $context  = stream_context_create($opts);
                    $result = file_get_contents($rg_url,false, $context);
                }

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
                'under_style'=> $under_style,
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
                'under_style'=> $under_style,
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
