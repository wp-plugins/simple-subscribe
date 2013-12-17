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


class TableSubscribes extends Table
{
    /** @var \SimpleSubscribe\RepositorySubscribers */
    var $subscribers;
    /** @var \SimpleSubscribe\Settings|\SimpleSubscribe\SimpleSubscribeSettings */
    var $settings;


    /**
     * Constructor
     *
     * @param Settings $settings
     * @param RepositorySubscribers $subscribers
     */

    function __construct(\SimpleSubscribe\Settings $settings, \SimpleSubscribe\RepositorySubscribers $subscribers)
    {
        global $status, $page;
        $this->subscribers = $subscribers;
        $this->settings = $settings;
        add_filter('set-screen-option', array('\SimpleSubscribe\TableSubscribes', 'setScreenOptions'), 100, 3);
        parent::__construct(array('singular'=> 'subscriber', 'plural' => 'subscribers', 'ajax'	=> FALSE));
    }


    /**
     * Basic setup, returns table columns.
     *
     * @return array
     */

    function get_columns()
    {
        return array_merge(
            array(
                'cb' => '<input type="checkbox" />',
                'email' => 'E-mail',
                'active' => 'Active?'),
            $this->settings->getTableColumns(),
            array(
                'date' => 'Registered',
                'ip' => 'IP')
        );
    }


    /**
     * Basic setup, returns sortable columns
     *
     * @return array
     */

    function get_sortable_columns()
    {
        return array(
            'email' => array('email',false),
            'firstName' => array('firstName',false),
            'lastName' => array('lastName',false),
            'age' => array('age',false),
            'location' => array('location',false)
        );
    }


    /**
     * Checkbox for bulk actions.
     *
     * @param $item
     * @return string
     */

    function column_cb($item)
    {
        if(!isset($item['wp'])){
            return sprintf( '<input type="checkbox" name="subscriberId[]" value="%s" />', $item['id']);
        }
        return NULL;
    }


    /**
     * Email column, with action buttons
     *
     * @param $item
     * @return string
     */

    function column_email($item)
    {
        $actions = array(
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>',$_GET['page'],'delete',$item['id']),
            'activate' => sprintf('<a href="?page=%s&action=%s&id=%s">Activate</a>',$_GET['page'],'activate',$item['id']),
            'deactivate' => sprintf('<a href="?page=%s&action=%s&id=%s">Deactivate</a>',$_GET['page'],'deactivate',$item['id']),
            'email' => sprintf('<a href="?page=%s&action=%s&email=%s">E-mail directly</a>','SimpleSubscribeEmail','email',$item['email'])
        );
        if(isset($item['wp'])){
            unset($actions['delete']);
            unset($actions['activate']);
            $actions['deactivate'] = sprintf('<a href="?page=%s&action=%s&id=%s">Deactivate</a>',$_GET['page'],'deactivateRegistered',$item['id']);
        } else {
            if(isset($item['active']) && $item['active'] == 1){
                unset($actions['activate']);
            } else {
                unset($actions['deactivate']);
            }
        }

        return sprintf('%1$s %2$s', $item['email'], $this->row_actions($actions));
    }


    /**
     * Easier to display, admin star if user is active or not.
     *
     * @param $item
     * @return string
     */

    function column_active($item)
    {
        if(!isset($item['wp'])){
            if($item['active'] == 1){
                return Html::el('a title="Deactivate Subscriber"')->href('', array('page' => $_GET['page'],'action' => 'deactivate','id' => $item['id']))->add(Html::el('span class="statusActive"'));
            }
            return Html::el('a title="Activate Subscriber"')->href('', array('page' => $_GET['page'],'action' => 'activate','id' => $item['id']))->add(Html::el('span class="statusInactive"'));
        }
        return Html::el('span')->setText(Html::el('small class="strong"')
                ->setHtml('Wordpress Registered User.<br />' . Html::el('a')
                    ->href('', array('page' => $_GET['page'],'action' => 'deactivateRegistered','id' => $item['id']))->setText('Deactivate.')));
    }


    /**
     * No Items notices
     */

    function no_items(){ _e('No subscribers to be listed.'); }


    /**
     * Bulk Actions
     *
     * @return array
     */

    function get_bulk_actions(){ return array('delete' => 'Delete', 'activate' => 'Activate', 'deactivate' => 'Deactivate'); }


    /**
     *  Prepares, sorts, delets, all that stuff :)
     */

    function prepare_items()
    {
        $this->process_bulk_action();
        $allSubscribers = $this->subscribers->getAllSubscribers();
        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());
        usort($allSubscribers, array(&$this, 'usort_reorder'));

        $perPage = $this->get_items_per_page('subscribersPerPage', 50);

        $this->found_data = array_slice($allSubscribers,(($this->get_pagenum()-1)* $perPage), $perPage);
        $this->set_pagination_args(array('total_items' => count($allSubscribers), 'per_page' => $perPage ));
        $this->items = $this->found_data;
    }


    /**
     * Processes bulk actions, delete, activate, deactivate
     */

    function process_bulk_action()
    {
        $subscribersBatch = isset($_POST['subscriberId']) ? ((is_array($_POST['subscriberId'])) ? $_POST['subscriberId'] : NULL) : (NULL);
        $subscriberId = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : NULL;
        try {
            switch ($this->current_action()){
                case 'delete':
                    if(!empty($subscribersBatch)){
                        $this->subscribers->deleteBatch($subscribersBatch);
                        $this->addNotice('updated', 'Subscriber(s) successfully deleted!');
                    } elseif(isset($_GET['action']) && is_numeric($_GET['id'])){
                        $this->subscribers->deleteUser($_GET['id']);
                        $this->addNotice('updated', 'Subscriber successfully deleted!');
                    }
                    break;
                case 'activate':
                    if(!empty($subscribersBatch)){
                        $this->subscribers->activateBatch($subscribersBatch);
                        $this->addNotice('updated', 'Subscriber(s) successfully activated!');
                    } elseif (isset($_GET['action']) && is_numeric($_GET['id'])){
                        $this->subscribers->activateUser($_GET['id']);
                        $this->addNotice('updated', 'Subscriber successfully activated!');
                    }
                    break;
                case 'deactivate':
                    if(!empty($subscribersBatch)){
                        $this->subscribers->deactivateBatch($subscribersBatch);
                        $this->addNotice('updated', 'Subscriber(s) successfully deactivated!');
                    } elseif (isset($_GET['action']) && is_numeric($_GET['id'])){
                        $this->subscribers->deactivateUser($_GET['id']);
                        $this->addNotice('updated', 'Subscriber successfully deactivated!');
                    }
                    break;
                case 'deactivateRegistered':
                        $this->subscribers->deactivateRegisteredUserById($_GET['id']);
                        $this->addNotice('updated', 'Subscriber successfully deactivated!');
                    break;
            }
        } catch (RepositarySubscribersException $e){
            $this->addNotice('error', $e->getMessage());
        }
    }


    /**
     * Process export
     */

    public static function process()
    {
        // export
        if(isset($_POST['export'])){
            try{
                $exporter = new \SimpleSubscribe\Exporter();
                $exporter->export($_POST['export'], $_POST['criteria']);
                $exporter->fin();
            } catch(RepositarySubscribersException $e){
                Admin::getInstance()->addNotice('error', $e->getMessage());
            }
        }
        // listing table per_itmems
        if(isset($_POST['wp_screen_options']['option']) && $_POST['wp_screen_options']['option'] == 'subscribersPerPage'){
            update_user_meta(
                get_current_user_id(),
                'subscribersPerPage',
                $_POST['wp_screen_options']['value'],
                get_user_meta(get_current_user_id(), 'subscribersPerPage', TRUE)
            );
        }
    }


    /**
     * Screen Options
     */

    public static function screenOptions()
    {
        add_screen_option('per_page', array(
            'label' => 'Subscribers',
            'default' => 50,
            'option' => 'subscribersPerPage'
        ));
    }
}
