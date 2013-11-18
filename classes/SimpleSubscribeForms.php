<?php
if (!defined('ABSPATH')) { exit; }

use Nette\Forms\Form,
    Nette\Utils\Html;

class SimpleSubscribeForms extends Nette\Object
{
    /**
     * Front-end subscription form
     *
     * @param array $fields
     * @return Nette\Forms\Form
     */

    public static function subscriptionForm($fields = array(), $widget = FALSE, $widgetId = '')
    {
        $form = new Form('subscriptionFront' . $widgetId);
        // Subscriber
        $form->addText('email', 'Your e-mail address')
            ->setRequired('E-mail address is requried.')
            ->addRule(Form::EMAIL, 'Your e-mail address must be valid.');
        if(array_key_exists('firstName', $fields)){ $form->addText('firstName', 'First Name'); }
        if(array_key_exists('lastName', $fields)){ $form->addText('lastName', 'Last Name'); }
        if(array_key_exists('age', $fields)){
            $form->addText('age', 'Age')
                ->addCondition(Form::FILLED)
                    ->addRule(Form::INTEGER, 'Age must be a numeric number.')
                    ->addRule(Form::RANGE, 'Age should be between 8 and 120 years :).', array(5, 120));;
        }
        if(array_key_exists('interests', $fields)){ $form->addTextarea('interests', 'Interests'); }
        if(array_key_exists('location', $fields)){ $form->addText('location', 'Location'); }
        // Submit
        $form->addSubmit('submit', 'Subscribe')->setAttribute('class', 'subscribeButton');

        // swap renderer for widgets
        if($widget == TRUE){
            $renderer = $form->getRenderer();
            $renderer->wrappers['controls']['container'] = 'dl';
            $renderer->wrappers['pair']['container'] = NULL;
            $renderer->wrappers['label']['container'] = 'dt';
            $renderer->wrappers['control']['container'] = 'dd';
        }
        return $form;
    }


    /**
     * Front-end unsubscription form
     *
     * @return Nette\Forms\Form
     */

    public static function unsubscriptionForm($widget = FALSE, $widgetId = '')
    {
        $form = new Form('unsubscriptionFront' . $widgetId);
        $form->addText('email', 'Your e-mail address')
            ->setRequired('To unsubscribe, you need to fill in your e-mail address.')
            ->addRule(Form::EMAIL, 'Your e-mail address must be valid.');
        $form->addSubmit('submit', 'Unsubscribe')->setAttribute('class', 'subscribeButton');

        // swap renderer for widgets
        if($widget == TRUE){
            $renderer = $form->getRenderer();
            $renderer->wrappers['controls']['container'] = 'dl';
            $renderer->wrappers['pair']['container'] = NULL;
            $renderer->wrappers['label']['container'] = 'dt';
            $renderer->wrappers['control']['container'] = 'dd';
        }

        return $form;
    }


    /**
     * Email template preview
     *
     * @return Nette\Forms\Form
     */

    public static function emailPreview()
    {
        // prefill default e-mail with current's users one
        if(function_exists('wp_get_current_user')){
            $currentUser = wp_get_current_user();
            $defaultEmail = $currentUser->user_email ? $currentUser->user_email : '';
        }
        $form = new Form('emailPreview');
        // Subscriber
        $form->addText('email', 'E-mail')
            ->setDefaultValue($defaultEmail)
            ->setRequired('E-mail address is requried.')
            ->addRule(Form::EMAIL, 'Must be valid e-mail address');
        $form->addCheckbox('post', 'Post Digest')->setDefaultValue(1);
        $form->addCheckbox('subscription', 'Subscription Confirmation')->setDefaultValue(0);
        // Submit
        $form->addSubmit('submit', 'Send E-mail preview')->setAttribute('class', 'button-primary');
        return $form;
    }


    /**
     * Add subscriber, from admin
     *
     * @param array $fields
     * @return Nette\Forms\Form
     */

    public static function subscribeAdmin($fields = array())
    {
        $form = new Form('addSubscriberAdmin');
        // Subscriber
        $form->addText('email', 'E-mail')
            ->setRequired('E-mail address is requried.')
            ->addRule(Form::EMAIL, 'Must be valid e-mail address');
        $form->addCheckbox('active', 'Active')->setDefaultValue(1);
        if(array_key_exists('firstName', $fields)){ $form->addText('firstName', 'First Name'); }
        if(array_key_exists('lastName', $fields)){ $form->addText('lastName', 'Last Name'); }
        if(array_key_exists('age', $fields)){
            $form->addText('age', 'Age')
                ->addCondition(Form::FILLED)
                ->addRule(Form::INTEGER, 'Age must be a numeric number.')
                ->addRule(Form::RANGE, 'Age should be between 8 and 120 years :).', array(5, 120));;
        }
        if(array_key_exists('interests', $fields)){ $form->addTextarea('interests', 'Interests'); }
        if(array_key_exists('location', $fields)){ $form->addText('location', 'Location'); }
        $form->addHidden('date', date('Y-m-d H:i:s'));
        $form->addText('ip', 'Ip')
            ->setDefaultValue(SimpleSubscribeUtils::getRealIp())
            ->addCondition(Form::FILLED)
            ->addRule(Form::PATTERN, 'Must be valid IP', '((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$');
        // Submit
        $form->addSubmit('submit', 'Save')->setAttribute('class', 'button-primary');

        return $form;
    }


    /**
     * Wordpress Settings Page Form
     *
     * @param null $defaults
     * @return Nette\Forms\Form
     */

    public static function settings($defaults = NULL)
    {
        $form = new Form('adminSettings');
        // Cron settings
        $form->addGroup('Cron Settings');
        $formCron = $form->addContainer('cron');
        $formCron->addSelect('timing', 'Select when the post e-mail should be sent.',
            array('When a new post is published.',
                'In the morning. (approx. 9AM)',
                'In the evening. (approx. 10PM)')
        );
        // Misc
        $form->addGroup('Miscellaneous Settings');
        $formMisc = $form->addContainer('misc');
        $formMisc->addSelect('deactivation', 'Upon user\'s unsubscription from e-mail digest',
            array('Delete User',
                'Only Deactivate User (that\'s evil)')
        );
        $formMisc->addText('senderEmail', 'Sender\'s e-mail address, one used to send e-mail digest from')
            ->setOption('description', 'Default: ' . get_option('admin_email'))
            ->addCondition(Form::FILLED)
            ->addRule(Form::EMAIL, 'Must be valid e-mail address');
        $formMisc->addText('senderName', 'Sender\'s name')
            ->setOption('description', 'Default: ' . html_entity_decode(get_option('blogname'), ENT_QUOTES));
        // Form fields
        $form->addGroup('Additional subscribe form fields');
        $formForm = $form->addContainer('form');
        $formForm->addCheckbox('firstName', 'First Name');
        $formForm->addCheckbox('lastName', 'Last Name');
        $formForm->addCheckbox('age', 'Age');
        $formForm->addCheckbox('interests', 'Interests');
        $formForm->addCheckbox('location', 'Location');
        // Js
        $form->addGroup('Front-end');
        $formVal = $form->addContainer('val');
        $formVal->addCheckbox('js', 'Use javascript validation in the front-end?');
        $formVal->addCheckbox('css', 'Use SimpleSubscribe stylesheet?');
        // Submit
        $form->addSubmit('submit', 'Save')->setAttribute('class', 'button-primary');

        // set dafaults
        if($defaults){ $form->setDefaults($defaults); }

        return $form;
    }


    /**
     * Email template settings in adin
     *
     * @param null $defaults
     * @return Nette\Forms\Form
     */

    public static function emailTemplate($defaults = NULL)
    {
        $form = new Form('adminEmailTemplate');
        // Email template
        $form->addGroup('E-mail template');
        $formEmail = $form->addContainer('emailType');
        $formEmail->addSelect(
            'source',
            'E-mail type',
            array(
                'HTML',
                'Plain Text')
        );
        $formEmail->addSelect(
            'type',
            'E-mail digest type',
            array(
                'Short Excerpt.',
                'Short Excerpt with Featured Image',
                'Whole Post (not recommended)')
        );
        // Design of e-mail
        $form->addGroup('E-mail design');
        $formDesign = $form->addContainer('emailDesign');
        $formDesign->addText('colourBg', 'Header background colour')
            ->setType('color')
            ->setOption('description','Default: #f5f5f5')
            ->addCondition(Form::FILLED)
            ->addRule(Form::PATTERN, 'Background colour must be a valid hex code.', '^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$');
        $formDesign->addText('colourTitle', 'Header title colour')
            ->setType('color')
            ->setOption('description','Default: #000000')
            ->addCondition(Form::FILLED)
            ->addRule(Form::PATTERN, 'Title colour must be a valid hex code.', '^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$');
        $formDesign->addText('colourLinks', 'Links colour')
            ->setType('color')
            ->setOption('description','Default: #000000')
            ->addCondition(Form::FILLED)
            ->addRule(Form::PATTERN, 'Link colour must be a valid hex code.', '^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$');
        // Social links
        $form->addGroup('Social Media Links');
        $formSocial = $form->addContainer('social');
        $formSocial->addText('twitter', 'Twitter profile URL')
            ->addCondition(Form::FILLED)
            ->addRule(Form::URL, 'Twitter profile URL, must be a valid URL.');
        $formSocial->addText('facebook', 'Facebook profile URL')
            ->addCondition(Form::FILLED)
            ->addRule(Form::URL, 'Facebook profile URL, must be a valid URL.');
        $formSocial->addText('pinterest', 'Pinterest profile URL')
            ->addCondition(Form::FILLED)
            ->addRule(Form::URL, 'Pinterest profile URL, must be a valid URL.');
        $formSocial->addText('youtube', 'Youtube profile URL')
            ->addCondition(Form::FILLED)
            ->addRule(Form::URL, 'Youtube profile URL, must be a valid URL.');
        $formSocial->addText('vimeo', 'Vimeo profile URL')
            ->addCondition(Form::FILLED)
            ->addRule(Form::URL, 'Vimeo profile URL, must be a valid URL.');
        // Submit
        $form->addSubmit('submit', 'Save')->setAttribute('class', 'button-primary');
        // set dafaults
        if($defaults){ $form->setDefaults($defaults); }

        return $form;
    }

}