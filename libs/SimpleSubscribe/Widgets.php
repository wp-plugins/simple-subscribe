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

use Nette\Utils\Html;


if(!class_exists('WP_Widget')){ require_once(ABSPATH . 'wp-admin/includes/widgets.php' ); }

class Widgets extends \Nette\Object
{

    /**
     * Register widgets
     */

    public static function register()
    {
        add_action('widgets_init', function(){
            register_widget('\SimpleSubscribe\WidgetAdd');
            register_widget('\SimpleSubscribe\WidgetRemove');
        });
    }
}


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
        $template = FrontEnd::subscriptionForm(TRUE, array_merge($args,$instance));
        echo $template;
    }


    /**
     * Widget settings form
     *
     * @param $instance
     */

    function form($instance)
    {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = strip_tags($instance['title']);
        echo Html::el('p')
            ->add(Html::el('label',
                array('for' => $this->get_field_id('title'))
                )->setText('Widget title:'))
            ->add(Html::el('input',
                array(
                    'class' => 'widefat',
                    'id' => $this->get_field_id('title'),
                    'name' => $this->get_field_name('title'),
                    'value' => esc_attr($title))));
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
        $template = FrontEnd::unsubscriptionForm(TRUE, array_merge($args,$instance));
        echo $template;
    }


    /**
     * Widget settings form
     *
     * @param $instance
     */

    function form($instance)
    {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = strip_tags($instance['title']);
        echo Html::el('p')
            ->add(Html::el('label',
            array('for' => $this->get_field_id('title'))
        )->setText('Widget title:'))
            ->add(Html::el('input class="widefat"',
            array(
                'id' => $this->get_field_id('title'),
                'name' => $this->get_field_name('title'),
                'value' =>  esc_attr($title))));
    }

}

class WidgetException extends \Exception{}
