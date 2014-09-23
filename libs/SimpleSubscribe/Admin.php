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

use Nette\Utils\Html;


class Admin extends \Nette\Object
{
    /** @var bool */
    private static $instance = false;
    /** @var array Admin Messages */
    var $notices = array();
    /** @var \SimpleSubscribeSettings */
    var $settings;
    /** @var \SimpleSubscribeListTable */
    var $listingTable;
    /** @var \RepositorySubscribers */
    var $subscribers;
    /** @var \RepositoryLog */
    var $log;
    /** @var bool|\SimpleSubscribeEmail */
    var $email;
    /** @var \Nette\Forms\Form settings form */
    var $formSettings;
    /** @var \Nette\Forms\Form email preview form */
    var $formEmailTemplate;
    /** @var \Nette\Forms\Form */
    var $formEmail;
    /** @var \Nette\Forms\Form add subscriber admin form */
    var $formSubscriber;
    /** @var \SimpleSubscribe\Nette\Forms\Form */
    var $formSubscriberWp;
    /** @var \Nette\Forms\Form email preview */
    var $formEmailPreview;


    /**
     * Constructor
     */




    public function __construct()
    {
        // admin actions
        add_action('admin_init', array($this, 'adminInit'));
        add_action('admin_menu', array($this, 'adminMenu'));
        add_action('admin_notices', array($this, 'adminNotices'));
        add_action('admin_enqueue_scripts', function(){ wp_enqueue_style('core', SUBSCRIBE_ASSETS . 'styleAdmin.css', null, '2.0'); wp_enqueue_script('netteForms', SUBSCRIBE_ASSETS . 'netteForms.js', array(), '1.0.0'); });
        // settings & forms
        $this->settings         = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
        $this->subscribers      = \SimpleSubscribe\RepositorySubscribers::getInstance();
        $this->log              = \SimpleSubscribe\RepositoryLog::getInstance();
        $this->email            = \SimpleSubscribe\Email::getInstance();
        $this->formSettings     = \SimpleSubscribe\Forms::settings($this->settings->getSettings());
        $this->formEmailTemplate= \SimpleSubscribe\Forms::emailTemplate($this->settings->getSettings());
        $this->formEmail        = \SimpleSubscribe\Forms::email($_GET);
        $this->formSubscriber   = \SimpleSubscribe\Forms::subscribeAdmin($this->settings->getTableColumns());
        $this->formSubscriberWp = \SimpleSubscribe\Forms::subscribeAdminWp($this->subscribers->getAllRegisteredInactive());
        $this->formEmailPreview = \SimpleSubscribe\Forms::emailPreview();
    }


    /**
     * @return bool|Admin
     */

    public static function getInstance()
    {
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * Admin Menu
     */

    public function adminMenu()
    {
        // Admin Pages
        add_menu_page('Subscribers', 'Subscribers', 'manage_options', 'SimpleSubscribe', array($this, 'renderAdminListing'), NULL, '71.22');
		if( file_exists(dirname(dirname(plugin_dir_path( __FILE__ )) ).'/readygraph-extension.php')) {
		global $menu_slug;
        add_submenu_page('SimpleSubscribe', 'Readygraph App', 'Readygraph App', 'manage_options', $menu_slug, 'readygraph_ss_menu_page');
		}
		else {	
		}
        add_submenu_page('SimpleSubscribe', 'E-mail template', 'E-mail template', 'manage_options', 'SimpleSubscribeEmailTemplate', array($this, 'renderAdminEmailTemplate'));
        add_submenu_page('SimpleSubscribe', 'E-mail subscribers', 'E-mail subscribers', 'manage_options', 'SimpleSubscribeEmail', array($this, 'renderAdminEmail'));
        add_submenu_page('SimpleSubscribe', 'Settings', 'Settings', 'manage_options', 'SimpleSubscribeSettings', array($this, 'renderAdminSettings'));
        add_submenu_page('SimpleSubscribe', 'Log', $this->log->menuTitle(), 'manage_options', 'SimpleSubscribeLog', array($this, 'renderAdminLog'));
		if( file_exists(dirname(dirname(plugin_dir_path( __FILE__ )) ).'/readygraph-extension.php')) {
		global $menu_slug;
        add_submenu_page('SimpleSubscribe', 'Go Premium', 'Go Premium', 'manage_options', 'readygraph-go-premium', 'readygraph_ss_premium');
		}
		else {	
		}
    }


    /**
     * Plugin action links
     *
     * @param $links
     * @param $file
     * @return mixed
     */

    public function adminPluginLinks($links, $file)
    {
        if ($file == 'simple-subscribe/SimpleSubsribe.php'){
            $settingsLink = Html::el('a')->href(admin_url('admin.php?page=SimpleSubscribeSettings'))->setText('Settings');
            $settingsProfileLink = Html::el('a')->href(admin_url('profile.php'))->setText('My Subscriptions');
            array_push($links, $settingsLink, $settingsProfileLink);
        }
        return $links;
    }


    /**
     * Plugin meta links
     *
     * @param $links
     * @param $file
     * @return mixed
     */

    public function adminPluginMeta($links, $file)
    {
        if ($file == 'simple-subscribe/SimpleSubsribe.php'){
            $ratePlugin = Html::el('a target="_blank"')->href('http://wordpress.org/support/view/plugin-reviews/simple-subscribe')->setText('Rate this plugin');
            $donatePlugin = Html::el('a target="_blank" class="red"')->href('http://donate.latorante.name/')->setText('Donate');
            array_push($links, $ratePlugin, $donatePlugin);
        }
        return $links;
    }


    /**
     * User subscription in the admin
     */

    public function adminUserProfile()
    {
        add_action('personal_options_update', function($user_id){
            if(isset($_POST['subscription'])){
                update_user_meta($user_id, 'subscription', $_POST['subscription'], get_user_meta($user_id, 'subscription', TRUE));
            } else {
                delete_user_meta($user_id, 'subscription');
            }
        });
        add_action('personal_options', function($profileuser){
            $subscription = get_user_meta($profileuser->ID, 'subscription', TRUE);
            $checked = $subscription == 1 ? TRUE : FALSE;
            echo Html::el('tr id="subscriptionSettings"')
                ->add(Html::el('th scope="row"')->setText('E-mail subscriptions'))
                ->add(Html::el('td')
                    ->add(Html::el('label')
                        ->add(Html::el('input type="checkbox" name="subscription" value="1"')->checked($checked))
                        ->add(Html::el('span')->setText(' Subscribe to new posts digest?'))));
        });
    }


    /**
     * Initialize admin settings
     */

    public function adminInit()
    {
        // filters
        add_filter('plugin_action_links',   array($this, 'adminPluginLinks'), 10, 2);
        add_filter('plugin_row_meta',       array($this, 'adminPluginMeta'), 10, 2);
        // Screen Options
        add_action('load-toplevel_page_SimpleSubscribe', array('\SimpleSubscribe\TableSubscribes', 'screenOptions'));
        add_filter('set-screen-option', function($status, $option, $value){ return $value; }, 10, 3);
        // actions
        add_action('new_to_publish',        array($this, 'onPublish'));
        add_action('draft_to_publish',      array($this, 'onPublish'));
        add_action('auto-draft_to_publish', array($this, 'onPublish'));
        add_action('pending_to_publish',    array($this, 'onPublish'));
        add_action('private_to_publish',    array($this, 'onPublish'));
        add_action('future_to_publish',     array($this, 'onPublish'));
        // email template image size
        add_image_size('simpleSubscribeEmail', 326, 169, TRUE);
        // process actions, register user profile
        $this->processActions();
        $this->adminUserProfile();
    }


    /**
     * What shall we do, what shall we do? :D
     *
     * @param $post
     */

    public function onPublish($post)
    {
        // settings
        $timing = $this->settings->getTiming();
        $inCategory = $this->settings->inCategory($post);

        if($post->post_type == 'post' && $inCategory){
            switch($timing){
                case 1:
                    \SimpleSubscribe\Cron::scheduleCron(Utils::NINE_AM, $post->ID);
                    $this->log->add(1, 'Cron scheduled, 9AM for Post ID: ' . $post->ID);
                    break;
                case 2:
                    \SimpleSubscribe\Cron::scheduleCron(Utils::NINE_PM, $post->ID);
                    $this->log->add(1, 'Cron scheduled, 9PM for Post ID: ' . $post->ID);
                    break;
                case 0:
                default:
                    $this->email->onPublish($post);
                    break;
            }
        }
    }


    /**
     * Do the magic
     */

    public function processActions()
    {
        // WP_List_Table export
        \SimpleSubscribe\TableSubscribes::process();
        // settings form
        if ($this->formSettings->isSubmitted() && $this->formSettings->isValid()){
            $values = $this->formSettings->getValues(TRUE);
            // if there are cateogires selected, and ALL as well, uncheck remaining
            if ((count(array_filter($values['cat'])) > 0) && ($values['cat']['0'] == TRUE)){
                foreach($values['cat'] as $key => $value){
                    $values['cat'][$key] = FALSE;
                    $this->formSettings['cat'][$key]->value = FALSE;
                }
                $values['cat']['0'] = TRUE;
                $this->formSettings['cat']['0']->value = TRUE;
            // if there is other category selected, unselect ALL
            } elseif (count(array_filter($values['cat'])) > 1){
                $values['cat']['0'] = FALSE;
                $this->formSettings['cat']['0']->value = FALSE;
                // if there's no category selected, select ALL
            } elseif (!in_array(TRUE, $values['cat'])){
                $values['cat']['0'] = TRUE;
                $this->formSettings['cat']['0']->value = TRUE;
            }
            $this->settings->saveSettings($values);
            $this->addNotice('updated', 'Settings successfully saved.');
        } elseif ($this->formSettings->hasErrors()){
            foreach($this->formSettings->getErrors() as $error){
                $this->addNotice('error', $error);
            }
        }
        // email template (saved in settings table tho)
        if ($this->formEmailTemplate->isSubmitted() && $this->formEmailTemplate->isValid()){
            $this->settings->saveSettings($this->formEmailTemplate->getValues(TRUE));
            $this->addNotice('updated', 'Settings successfully saved.');
        } elseif ($this->formEmailTemplate->hasErrors()){
            foreach($this->formEmailTemplate->getErrors() as $error){
                $this->addNotice('error', $error);
            }
        }
        // mass email
        if ($this->formEmail->isSubmitted() && $this->formEmail->isValid()){
            try{
                $this->email->sendMassEmail($this->formEmail->getValues(TRUE));
                $this->addNotice('updated', 'Email successfully sent.');
            } catch (EmailException $e){
                $this->addNotice('error', $e->getMessage());
            }
        } elseif ($this->formEmail->hasErrors()){
            foreach($this->formEmail->getErrors() as $error){
                $this->addNotice('error', $error);
            }
        }
        // subscriber form
        if ($this->formSubscriber->isSubmitted() && $this->formSubscriber->isValid()){
            try{
                $this->subscribers->addThruAdmin($this->formSubscriber->getValues());
                $this->addNotice('updated', 'Subscriber successfully added.');
            } catch (RepositarySubscribersException $e){
                $this->addNotice('error', $e->getMessage());
            }
        } elseif ($this->formSubscriber->hasErrors()){
            foreach($this->formSubscriber->getErrors() as $error){
                $this->addNotice('error', $error);
            }
        }
        // wp subscriber form
        if ($this->formSubscriberWp->isSubmitted() && $this->formSubscriberWp->isValid()){
            try{
                $users = $this->formSubscriberWp->getValues(TRUE);
                $this->subscribers->addWpRegistered($users['users']);
                $this->addNotice('updated', 'Subscriber(s) successfully added.');
            } catch (RepositarySubscribersException $e){
                $this->addNotice('error', $e->getMessage());
            }
        } elseif ($this->formSubscriberWp->hasErrors()){
            foreach($this->formSubscriberWp->getErrors() as $error){
                $this->addNotice('error', $error);
            }
        }
        // email preview form
        if ($this->formEmailPreview->isSubmitted() && $this->formEmailPreview->isValid()){
            try{
                $this->email->sendEmailPreview($this->formEmailPreview->getValues(TRUE));
                $this->addNotice('updated', 'Email Preview successfully sent.');
            } catch (EmailException $e){
                $this->addNotice('error', $e->getMessage());
            }
        } elseif ($this->formEmailPreview->hasErrors()){
            foreach($this->formEmailPreview->getErrors() as $error){
                $this->addNotice('error', $error);
            }
        }
    }


    /**
     * Renders Admin Page
     */

    public function renderAdminListing()
    {
        $table = new \SimpleSubscribe\TableSubscribes($this->settings, $this->subscribers);
        $table->prepare_items();
        // template
        $template = new \SimpleSubscribe\Template('adminPage.latte');
        $template->prepareTemplate(array('formSubscriber' => $this->formSubscriber, 'formSubscriberWp' => $this->formSubscriberWp, 'table' => $table));

        echo $template->getTemplate();
    }


    /**
     * Renders e-mail template settings page
     */

/*    public function add_ssubscribe_app_register_page(){
        $template = new \SimpleSubscribe\Template('ssubscribe_app_page.php');
        $template->prepareTemplate(array('formEmailTemplate' => $this->formEmailTemplate, 'formEmailPreview' => $this->formEmailPreview));
        echo $template->getTemplate();
    }
*/
    public function renderAdminEmailTemplate()
    {
        // template
        $template = new \SimpleSubscribe\Template('adminEmailTemplate.latte');
        $template->prepareTemplate(array('formEmailTemplate' => $this->formEmailTemplate, 'formEmailPreview' => $this->formEmailPreview));
        echo $template->getTemplate();
    }



    public function renderAdminEmail()
    {
        // template
        $template = new \SimpleSubscribe\Template('adminEmail.latte');
        $template->prepareTemplate(array('formEmail' => $this->formEmail));
        echo $template->getTemplate();
    }


    /**
     * Renders admin subpage - that being the settings page.
     */

    public function renderAdminSettings()
    {
        // template
        $template = new \SimpleSubscribe\Template('adminSubpage.latte');
        $template->prepareTemplate(array('formSettings' => $this->formSettings));
        echo $template->getTemplate();
    }


    /**
     * Renders admin log, errors, q messages
     */

    public function renderAdminLog()
    {
        $table = new \SimpleSubscribe\TableLogs($this->log);
        $table->prepare_items();
        // template
        $template = new \SimpleSubscribe\Template('adminLog.latte');
        $template->prepareTemplate(array('table' => $table));
        echo $template->getTemplate();
    }


    /**
     * Adds notice to the array of notices
     *
     * @param string $tag
     * @param string $label
     */

    public function addNotice($tag = 'updated', $label = ''){ $this->notices[] = array($tag, $label); }


    /**
     * Returns all notices
     *
     * @return array
     */

    public function getNotices(){ return $this->notices; }


    /**
     * Sends notices to renderer
     */

    public function adminNotices()
    {
        foreach($this->notices as $key => $value){
            $this->displayAdminNotice($value[0], $value[1]);
        }
    }


    /**
     * Display admin notices
     *
     * @param null $class
     * @param null $text
     */

    public function displayAdminNotice($class = NULL,$text = NULL){ echo Html::el('div id="message"')->class(array($class, 'strong'))->add(Html::el('p')->setHtml($text)); }
}