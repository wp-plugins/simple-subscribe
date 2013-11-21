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


class Shortcodes
{
    /**
     * Register shortcodes
     */

    public static function register()
    {
        add_shortcode('simpleSubscribeForm',    '\SimpleSubscribe\Shortcodes::subscriptionForm');
        add_shortcode('simpleUnsubscribeForm',  '\SimpleSubscribe\Shortcodes::unsubscriptionForm');
    }


    /**
     * Subscription form shortcode
     */

    public static function subscriptionForm()
    {
        $template = \SimpleSubscribe\FrontEnd::subscriptionForm(FALSE);
        echo $template;
    }


    /**
     * Unsubscription form shortcode
     */

    public static function unsubscriptionForm()
    {
        $template = \SimpleSubscribe\FrontEnd::unsubscriptionForm(FALSE);
        echo $template;
    }
}
