<?php
if (!defined('ABSPATH')) { exit; }

use Nette\Utils\Html;

class SimpleSubscribeAdmin extends Nette\Object
{
    /** @var bool */
    private static $instance = false;
    /** @var array Admin Messages */
    var $notices = array();
    /** @var settings class */
    var $settings;
    /** @var \SimpleSubscribeListTable */
    var $listingTable;
    /** @var bool|\SimpleSubscribeEmail */
    var $email;
    /** @var \SimpleSubscribe subscribers */
    var $subscribers;
    /** @var \Nette\Forms\Form settings form */
    var $formSettings;
    /** @var \Nette\Forms\Form email preview form */
    var $formEmailTemplate;
    /** @var \Nette\Forms\Form add subscriber admin form */
    var $formSubscriber;
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
        add_action('admin_enqueue_scripts', function(){ wp_enqueue_style('core', SUBSCRIBE_ASSETS . 'styleAdmin.css'); wp_enqueue_script('netteForms', SUBSCRIBE_ASSETS . 'netteForms.js', array(), '1.0.0'); });
        // settings & forms
        $this->settings         = new SimpleSubscribeSettings(SUBSCRIBE_KEY);
        $this->email            = SimpleSubscribeEmail::getInstance();
        $this->subscribers      = SimpleSubscribeSubscribers::getInstance();
        $this->formSettings     = SimpleSubscribeForms::settings($this->settings->getSettings());
        $this->formEmailTemplate= SimpleSubscribeForms::emailTemplate($this->settings->getSettings());
        $this->formSubscriber   = SimpleSubscribeForms::subscribeAdmin($this->settings->getTableColumns());
        $this->formEmailPreview = SimpleSubscribeForms::emailPreview();
    }


    /**
     * @return bool|SimpleSubscribeAdmin
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
        add_menu_page('Subscribers', 'Subscribers', 'manage_options', 'SimpleSubscribe', array($this, 'renderAdminListing'), NULL, '71.22');
        add_submenu_page('SimpleSubscribe', 'E-mail template', 'E-mail template', 'manage_options', 'SimpleSubscribeEmailTemplate', array($this, 'renderAdminEmailTemplate'));
        add_submenu_page('SimpleSubscribe', 'Settings', 'Settings', 'manage_options', 'SimpleSubscribeSettings', array($this, 'renderAdminSettings'));
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
     * User subscription in the admin
     */

    public function adminUserProfile()
    {
        add_action('personal_options_update', function($user_id){
            if(isset($_POST['subscription'])){
                update_user_meta($user_id, 'subscription', $_POST['subscription'], get_user_meta( $user_id, 'subscription', true ));
            } else {
                delete_user_meta($user_id,'subscription');
            }
        });
        add_action('personal_options', function($profileuser){
            $subscription = get_user_meta($profileuser->ID, 'subscription', true);
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
        // TODO: add admin option for selected post types
        if($post->post_type == 'post'){
            $timingSettings = $this->settings->getTiming();
            $timing = !empty($timingSettings) ? $this->settings->getTiming() : 0;
            switch($timing){
                case 1:
                    SimpleSubscribeCron::scheduleCron(SimpleSubscribeUtils::NINE_AM, $post->ID);
                    break;
                case 2:
                    SimpleSubscribeCron::scheduleCron(SimpleSubscribeUtils::NINE_PM, $post->ID);
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
        SimpleSubscribeListTable::processExport();
        // settings form
        if ($this->formSettings->isSubmitted() && $this->formSettings->isValid()){
            $this->settings->saveSettings($this->formSettings->getValues(TRUE));
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
        // subscriber form
        if ($this->formSubscriber->isSubmitted() && $this->formSubscriber->isValid()){
            try{
                $this->subscribers->addThruAdmin($this->formSubscriber->getValues());
                $this->addNotice('updated', 'Subscriber successfully added.');
            } catch (SubscribersException $e){
                $this->addNotice('error', ''. $e->getMessage() .'');
            }
        } elseif ($this->formSubscriber->hasErrors()){
            foreach($this->formSubscriber->getErrors() as $error){
                $this->addNotice('error', $error);
            }
        }
        // email preview form
        if ($this->formEmailPreview->isSubmitted() && $this->formEmailPreview->isValid()){
            try{
                $this->email->sendEmailPreview($this->formEmailPreview->getValues(TRUE));
                $this->addNotice('updated', 'Email Preview successfully sent.');
            } catch (EmailException $e){
                $this->addNotice('error', ''. $e->getMessage() .'');
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
        $table = new SimpleSubscribeListTable($this->settings, $this->subscribers);
        $table->prepare_items();
        // defaults
        $defaults = array( 'formSubscriber' => $this->formSubscriber, 'table' => $table);
        // template
        $template = new SimpleSubscribeTemplate('adminPage.latte');
        $template->prepareTemplate($defaults);

        echo $template->getTemplate();
    }


    /**
     * E-mail template settings page
     */

    public function renderAdminEmailTemplate()
    {
        // defaults
        $defaults = array('formEmailTemplate' => $this->formEmailTemplate, 'formEmailPreview' => $this->formEmailPreview);
        // template
        $template = new SimpleSubscribeTemplate('adminEmailTemplate.latte');
        $template->prepareTemplate($defaults);

        echo $template->getTemplate();
    }


    /**
     * Renders admin subpage - that being the settings page.
     */

    public function renderAdminSettings()
    {
        // defaults
        $defaults = array('formSettings' => $this->formSettings);
        // template
        $template = new SimpleSubscribeTemplate('adminSubpage.latte');
        $template->prepareTemplate($defaults);

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