<?php
if (!defined('ABSPATH')) { exit; }


class SimpleSubscribeShortcodes
{
    /**
     * Register shortcodes
     */

    public static function register()
    {
        add_shortcode('simpleSubscribeForm',    'SimpleSubscribeShortcodes::subscriptionForm');
        add_shortcode('simpleUnsubscribeForm',  'SimpleSubscribeShortcodes::unsubscriptionForm');
    }


    /**
     * Subscription form shortcode
     */

    public static function subscriptionForm()
    {
        $template = SimpleSubscribeFrontEnd::subscriptionForm(FALSE);
        echo $template;
    }


    /**
     * Unsubscription form shortcode
     */

    public static function unsubscriptionForm()
    {
        $template = SimpleSubscribeFrontEnd::unsubscriptionForm(FALSE);
        echo $template;
    }
}
