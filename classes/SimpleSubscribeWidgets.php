<?php
if (!defined('ABSPATH')) { exit; }

if(!class_exists('WP_Widget')){ require_once(ABSPATH . 'wp-admin/includes/widgets.php' ); }

class SimpleSubscribeAddWidget extends WP_Widget
{

    /**
     * Constructor registers widget in wordpress
     */

    function __construct()
    {
        parent::__construct(
            'simpleSubscribe',
            'Subscribe',
            array('description' => 'Subscription form.')
        );
    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */

    public function widget($args, $instance)
    {
        $template = SimpleSubscribeFrontEnd::subscriptionForm(TRUE, $args);
        echo $template;
    }

}


class SimpleSubscribeRemoveWidget extends WP_Widget
{

    /**
     * Constructor registers widget in wordpress
     */

    function __construct()
    {
        parent::__construct(
            'simpleSubscribeRemove',
            'Unsubscribe',
            array('description' => 'Unsubscription form.')
        );
    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */

    public function widget($args, $instance)
    {
        $template = SimpleSubscribeFrontEnd::unsubscriptionForm(TRUE, $args);
        echo $template;
    }

}

class WidgetException extends Exception{}
