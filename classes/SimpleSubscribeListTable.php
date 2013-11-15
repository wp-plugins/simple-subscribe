<?php
if (!defined('ABSPATH')) { exit; }

use Nette\Utils\Html;

if(!class_exists('WP_List_Table')){ require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ); }

class SimpleSubscribeListTable extends WP_List_Table
{
    /** @var \SimpleSubscribeSubscribers */
    var $subscribers;
    /** @var \SimpleSubscribeSettings */
    var $settings;
    /** @var array() */
    var $notices;


    /**
     * Constructor
     *
     * @param SimpleSubscribeSettings $settings
     * @param SimpleSubscribeSubscribers $subscribers
     */

    function __construct(SimpleSubscribeSettings $settings, SimpleSubscribeSubscribers $subscribers)
    {
        global $status, $page;
        $this->subscribers = $subscribers;
        $this->settings = $settings;
        parent::__construct(array('singular'=> 'subscriber', 'plural' => 'subscribers', 'ajax'	=> false));
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
                'email' => 'E-mail'),
            $this->settings->getTableColumns(),
            array(
                'active' => 'Active?',
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
     * Default columns display behaviour
     *
     * @param $item
     * @param $column_name
     * @return mixed
     */

    function column_default($item, $column_name){ return $item[$column_name]; }


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
            'deactivate' => sprintf('<a href="?page=%s&action=%s&id=%s">Deactivate</a>',$_GET['page'],'deactivate',$item['id'])
        );
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
        return Html::el('span')->setText(Html::el('small class="strong"')->setText('Wordpress Registered User.'));
    }


    /**
     * No Items notices
     */

    function no_items(){ _e('No subscribers to be listed.'); }


    /**
     * Reordering function.
     *
     * @param $a
     * @param $b
     * @return int
     */

    function usort_reorder($a, $b)
    {
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
        $result = strcmp($a[$orderby], $b[$orderby]);
        return ($order === 'asc') ? $result : -$result;
    }


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

        $allSubscribers = array_merge($this->subscribers->getAll(), $this->subscribers->getAllRegistered());

        $this->_column_headers = array($this->get_columns(), array(), $this->get_sortable_columns());
        usort($allSubscribers, array(&$this, 'usort_reorder'));

        $perPage = 50; // set per page

        $this->found_data = array_slice($allSubscribers,(($this->get_pagenum()-1)* $perPage), $perPage);

        $this->set_pagination_args(array(
            'total_items' => count($allSubscribers),
            'per_page'    => $perPage
        ));
        $this->items = $this->found_data;
    }


    /**
     * Processes bulk actions, delete, activate, deactivate
     */

    function process_bulk_action()
    {
        $subscribersBatch = isset($_POST['subscriberId']) ? ((is_array($_POST['subscriberId'])) ? $_POST['subscriberId'] : NULL) : (NULL);
        $subscriberId = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : NULL;
        switch ($this->current_action()){
            case 'delete':
                if(!empty($subscribersBatch)){
                    $this->subscribers->deleteBatch($subscribersBatch);
                    $this->addNotice('updated', 'Subscriber(s) successfully deleted!');
                } elseif (isset($_GET['action']) && is_numeric($_GET['id'])){
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
        }
    }


    /**
     * Process export
     */

    public static function processExport()
    {
        if(isset($_POST['export'])){
            try{
                $exporter = new SimpleSubscribeExporter();
                $exporter->export($_POST['export'], $_POST['criteria']);
                $exporter->fin();
            } catch(SubscribersException $e){
                SimpleSubscribeAdmin::getInstance()->addNotice('error', $e->getMessage());
            }
        }
    }


    /**
     * Get notices
     *
     * @return mixed
     */

    public function getNotices(){ return $this->notices; }


    /**
     * Has Messages
     *
     * @return bool
     */

    public function hasNotices(){ if(!empty($this->notices)){ return TRUE; } return FALSE; }


    /**
     * Adds Message to be returned later - anywhere we want
     *
     * @param $key
     * @param $msg
     */

    private function addNotice($key, $msg)
    {
        $this->notices[] = array($key, $msg);
        SimpleSubscribeAdmin::getInstance()->displayAdminNotice($key, $msg);
    }
}
