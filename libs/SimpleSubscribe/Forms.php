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

use Nette\Forms\Form,
    Nette\Utils\Html;


class Forms
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
            ->setDefaultValue(Utils::getRealIp())
            ->addCondition(Form::FILLED)
            ->addRule(Form::PATTERN, 'Must be valid IP', '((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$');
        // Submit
        $form->addSubmit('submit', 'Add')->setAttribute('class', 'button-primary');

        return $form;
    }


    /**
     * Add subscriber, from admin
     *
     * @param array $fields
     * @return Nette\Forms\Form
     */

    public static function subscribeAdminWp($registered = array())
    {
        $form = new Form('addSubscriberAdminWp');
        // Wordpress users
        $form->addMultiSelect('users', 'Wordpress users:', $registered)
            ->setRequired('If you want to add a wordpress registered user, you have to select one first.')
            ->setOption('description', 'If this form is empty, there aren\'t any wordpress registered subscribers to be added.');
        // Submit
        $form->addSubmit('submit', 'Add')->setAttribute('class', 'button-primary');
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
        // prep
        $emailSubjectName = isset($defaults['senderName']) ? $defaults['senderName'] : html_entity_decode(get_option('blogname'), ENT_QUOTES);

        // Form
        $form = new Form('adminSettings');
        // Cron settings
        $form->addGroup('Cron Settings');
        $formCron = $form->addContainer('cron');
        $formCron->addSelect('timing', 'Select when the post e-mail should be sent.',
            array('When a new post is published. (not recommended)',
                'In the morning. (approx. 9AM)',
                'In the evening. (approx. 9PM)')
        );
        // Misc
        $form->addGroup('Miscellaneous Settings');
        $formMisc = $form->addContainer('misc');
        $formMisc->addSelect('deactivation', 'Upon user\'s unsubscription from e-mail digest',
            array(
                'Delete User',
                'Only Deactivate User (that\'s evil)')
        );
        $formMisc->addText('senderEmail', 'Sender\'s e-mail address, one used to send e-mail digest from')
            ->setOption('description', 'Default: ' . get_option('admin_email'))
            ->addCondition(Form::FILLED)
            ->addRule(Form::EMAIL, 'Must be valid e-mail address');
        $formMisc->addText('senderName', 'Sender\'s name')
            ->setOption('description', 'Default: ' . html_entity_decode(get_option('blogname'), ENT_QUOTES));
        $formMisc->addSelect('emailSubject', 'Post digest e-mail subject',
            array(
                'New Post from ' . $emailSubjectName,
                'POST_TITLE by ' . $emailSubjectName,
                'POST_TITLE')
        );
        $formMisc->addCheckbox('log', 'Enable message log')
            ->setOption('description', '(logs errors, cron schedules, successfully sent digests, etc.)');
        // if blog is on different url, allow users to select back button url
        if(\SimpleSubscribe\Utils::getPostsPageUrl()){
            $homeUrlDesc = Html::el('small')->setHtml('Backlink on '. Html::el('a', array('href' => SUBSCRIBE_API_URL, 'target' => '_blank'))->setText('confirmation / unsubscription page') .', by default it\'s homepage.');
            $formMisc->addSelect('homeUrl', 'Homepage link',array(SUBSCRIBE_HOME_URL,\SimpleSubscribe\Utils::getPostsPageUrl()))
                ->setOption('description', $homeUrlDesc);
        }
        // Form fields
        $form->addGroup('Additional subscribe form fields');
        $formForm = $form->addContainer('form');
        $formForm->addCheckbox('firstName', 'First Name');
        $formForm->addCheckbox('lastName', 'Last Name');
        $formForm->addCheckbox('age', 'Age');
        $formForm->addCheckbox('interests', 'Interests');
        $formForm->addCheckbox('location', 'Location');
        // Categories
        $form->addGroup('Digest Category');
        $formCat = $form->addContainer('cat');
        // List thru categories
        $formCat->addCheckbox('0', 'All')->setOption('description', 'If you select All, the other categories will deselect automatically.');
        foreach(get_categories(array('hide_empty' => 0)) as $category){
            $formCat->addCheckbox($category->term_id, $category->name);
        }
        $form->addGroup();

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
        $formDesign->addText('colourBodyBg', 'E-mail background colour')
            ->setType('color')
            ->setOption('description','Default: #ececec')
            ->addCondition(Form::FILLED)
            ->addRule(Form::PATTERN, 'Background colour must be a valid hex code.', '^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$');
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

        foreach(Settings::getSocialServices() as $key => $value){
            $formSocial->addText($key, $value . ' profile URL')
                ->addCondition(Form::FILLED)
                ->addRule(Form::URL, $value . ' profile URL, must be a valid URL.');
        }

        // Submit
        $form->addSubmit('submit', 'Save')->setAttribute('class', 'button-primary');
        // set dafaults
        if($defaults){ $form->setDefaults($defaults); }

        return $form;
    }


    /**
     * Email subscribers
     *
     * @return \Nette\Forms\Form
     */

    public static function email(array $get)
    {
        $form = new Form('adminEmail');

        // Prepare
        if(isset($get['action']) && $get['action'] == 'email'){ $preFill = TRUE; } else { $preFill = FALSE; }
        $emailWhoDefault = $preFill ? 2 : 1;
        $emailSubscriberDefault = isset($get['email']) ? $get['email'] : '';

        // Email subscribers
        $form->addGroup('E-mail Subscriber(s)');
        $form->addSelect('emailWho', 'Recipient(s)', array(
            1 => 'All subscriber(s)',
            2 => 'Single Subscriber',
            3 => 'Wordpress Registered subscribers',
            4 => 'Non-wordpress Registered subscribers'))
            ->setDefaultValue($emailWhoDefault)
            ->addCondition(Form::EQUAL, 2)
            ->toggle("subscriber");
        $form->addGroup()->setOption('container', Html::el('fieldset')->id("subscriber"));
        $form->addText("email", "Subscriber")
            ->setDefaultValue($emailSubscriberDefault)
            ->addCondition(Form::FILLED)
            ->addRule(Form::EMAIL, 'Must be valid e-mail address');
        $form->addGroup();
        $form->addText('subject', 'Subject')
            ->setRequired('Subject is required');
        $form->addTextArea('body', 'E-mail message')
            ->setRequired('You don\'t want to send an empty message now do you :)');
        // Submit
        $form->addSubmit('submit', 'Send')->setAttribute('class', 'button-primary');

        return $form;
    }

}