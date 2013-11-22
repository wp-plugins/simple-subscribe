<?php

/**
 * This file is part of the Simple Subscribe plugin.
 *
 * Copyright (c) 2013 Martin Picha (http://latorante.name)
 *
 * For the full copyright and license information, please view
 * the SimpleSubscribe.php file in root directory of this plugin.
 */

namespace SimpleSubscribe;


if(!class_exists('WP_Widget')){ require_once(ABSPATH . 'wp-admin/includes/widgets.php' ); }

class WidgetAdd extends \WP_Widget
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
        $template = FrontEnd::subscriptionForm(TRUE, $args);
        echo $template;
    }

}


class WidgetRemove extends \WP_Widget
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
        $template = FrontEnd::unsubscriptionForm(TRUE, $args);
        echo $template;
    }

}

class WidgetException extends \Exception{}
