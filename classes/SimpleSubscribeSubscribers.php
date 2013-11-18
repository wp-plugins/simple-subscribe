<?php
if (!defined('ABSPATH')) { exit; }

class SimpleSubscribeSubscribers
{
    /** @var bool */
    private static $instance = false;
    /** @var string */
    var $tableName;
    /** @var string */
    var $salt;
    /** @var \SimpleSubscribeSettings */
    var $settings;
    /** @var mixed */
    var $settingsAll;
    /** @var Wordpress WPDB object */
    var $wpdb;


    /**
     * Constructor sets wpdb
     */

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->tableName = $wpdb->prefix . 'subscribers';
        $this->salt = $this->tableName;
        $this->settings = new SimpleSubscribeSettings(SUBSCRIBE_KEY);
        $this->settingsAll = $this->settings->getSettings();
    }


    /**
     * @return bool|SimpleSubscribeSubscribers
     */

    public static function getInstance()
    {
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * Validate API Call
     *
     * @param $id
     * @param $hash
     * @return bool
     * @throws SubscribersException
     */

    public function validateApiCall($id, $hash)
    {
        if($this->userExistsById($id)){
            return $this->checkUserHash($this->getById($id), $hash);
        } else {
            throw new SubscribersException('User doesn\'t exists.');
        }
    }


    /**
     * Repository helpers for better maneuvering.
     */


    /**
     * Is user active?
     *
     * @param $id
     * @return bool
     */

    public function isActive($id){ return $this->wpdb->get_var($this->wpdb->prepare("SELECT active FROM $this->tableName WHERE id=%d", $id)) == '1' ? TRUE : FALSE; }


    /**
     * Activates user
     *
     * @param $id
     * @return mixed
     * @throws SubscribersException
     */

    public function activateUser($id)
    {
        if($this->isActive($id)){
            throw new SubscribersException('This subscriber is already active!');
        } else {
            return $this->wpdb->update($this->tableName, array('active' => '1'), array( 'id' => $id));
        }
    }


    /**
     * Activates batch
     *
     * @param array $batch
     */

    public function activateBatch(array $batch) { foreach($batch as $id){ $this->activateUser($id); } }


    /**
     * Deactivates user
     *
     * @param $id
     * @return mixed
     */

    public function deactivateUser($id) { return $this->wpdb->update($this->tableName, array('active' => '0'), array( 'id' => $id)); }


    /**
     * Deactivates batch
     *
     * @param array $batch
     */

    public function deactivateBatch(array $batch) { foreach($batch as $id){ $this->deactivateUser($id); } }


    /**
     * Deletes user
     *
     * @param $id
     * @return mixed
     */

    public function deleteUser($id){ return $this->wpdb->delete($this->tableName, array( 'id' => $id)); }


    /**
     * Deletes batch
     *
     * @param array $batch
     */

    public function deleteBatch(array $batch) { foreach($batch as $id){ $this->deleteUser($id); } }


    /**
     * Decides what to do, deactivate, or delete? according to settings in admin
     *
     * @param $email
     */

    public function deleteOrDeactivateByEmail($email)
    {
        $delete = isset($this->settingsAll['misc']['deactivation']) ? ($this->settingsAll['misc']['deactivation'] == 0 ? TRUE : FALSE) : TRUE;
        if($delete == TRUE){
            $this->deleteUserByEmail($email);
        } else {
            $this->deactivateUserByEmail($email);
        }
    }


    /**
     * Used by API
     *
     * @param $email
     * @throws SubscribersException
     */

    public function deleteUserByEmail($email)
    {
        if($this->userByEmailExists($email)){
            $this->deleteUser($this->getUserIdByEmail($email));
        } else {
            throw new SubscribersException('User with this e-mail address does not exist!');
        }
    }


    /**
     * Used by API
     *
     * @param $email
     * @throws SubscribersException
     */

    public function deactivateUserByEmail($email)
    {
        if($this->userByEmailExists($email)){
            $this->deactivateUser($this->getUserIdByEmail($email));
        } else {
            throw new SubscribersException('User with this e-mail address does not exist!');
        }
    }


    /**
     * Get user by id
     *
     * @param int $id
     * @return bool
     */

    public function getById($id = 0)
    {
        if (!$id){ return false; }
        return $this->wpdb->get_var($this->wpdb->prepare("SELECT email FROM $this->tableName WHERE id=%d", $id));
    }


    /**
     * Get user by email addresss
     *
     * @param $email
     * @return bool
     */

    public function getUserIdByEmail($email)
    {
        if (!$email){ return false; }
        return $this->wpdb->get_var($this->wpdb->prepare("SELECT id FROM $this->tableName WHERE email=%s", $email));
    }


    /**
     * Checks hash
     *
     * @param $email
     * @param $hash
     * @return bool
     */

    public function checkUserHash($email, $hash)
    {
        if($this->getUserHash($email) == $hash){
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Creates Hash
     *
     * @param $email
     * @return string
     */

    public function getUserHash($email) { return sha1($this->salt . $email); }


    /**
     * Check if user exist, by his e-mail in our db, or wordpress users
     *
     * @param $email
     * @return bool
     */

    public function userByEmailExists($email)
    {
        if($this->getUserIdByEmail($email) || email_exists($email)){
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Check if user exits. by his id
     *
     * @param $id
     * @return bool
     */

    public function userExistsById($id)
    {
        if($this->getById($id)){
            return TRUE;
        }
        return FALSE;
    }


    /**
     * I thought it was clear from the name, yup, it adds user.
     *
     * @param $data
     */

    public function add($data)
    {
        if($this->userByEmailExists($data->email)){
            throw new SubscribersException('We\'re really sorry, but user with this e-mail address already exists.',0);
        } else {
            $data->active = 0;
            if($this->wpdb->insert($this->tableName, (array)$data)){
                try{
                    $email = SimpleSubscribeEmail::getInstance();
                    $email->sendConfiramtionEmail($data->email,  $this->wpdb->insert_id);
                } catch (EmailException $e){
                    throw new SubscribersException($e->getMessage());
                }
            }
            return TRUE;
        }
    }


    /**
     * Same as above, just leaves the confirmation e-mail out, and
     * adds the entry active. That's evil mate, you can add a person
     * to annoying newsletter without them knowing? I don't like that.
     *
     * @param $data
     * @return mixed
     */

    public function addThruAdmin($data)
    {
        if($this->userByEmailExists($data->email)){
            throw new SubscribersException('We\'re really sorry, but user with this e-mail address already exists.', 0);
        } else {
            return $this->wpdb->insert($this->tableName, (array)$data);
        }
    }


    /**
     * Getter for WP_List_Table class in admin
     *
     * @return mixed
     */

    public function getAll(){ return $this->wpdb->get_results("SELECT * FROM $this->tableName", ARRAY_A); }


    /**
     * Returns register and active users
     *
     * @return array
     */

    public function getAllRegistered()
    {
        $return = array();
        $registeredUsers = get_users(array('meta_key' => 'subscription','meta_value' => 1) );
        if(!empty($registeredUsers)){
            foreach($registeredUsers as $user){
                $return[] = array(
                    'id' => $user->data->ID,
                    'email' => $user->data->user_email,
                    'firstName' => NULL,
                    'lastName' => NULL,
                    'age' => NULL,
                    'location' => NULL,
                    'interests' => NULL,
                    'date' => NULL,
                    'ip' => NULL,
                    'wp' => TRUE
                );
            }
        }
        return $return;
    }


    /**
     * Removes registered user from subscription
     *
     * @param $id
     * @return mixed
     */

    public function deactivateRegisteredUserById($id){ return delete_user_meta($id, 'subscription'); }


    /**
     * Returns registered user by id
     *
     * @param $id
     * @return mixed
     */

    public function getRegisteredUserById($id){ return $this->wpdb->get_var($this->wpdb->prepare("SELECT email FROM $this->wpdb->users WHERE id=%d", $id)); }


    /**
     * Get all public subcribers
     *
     * @param int $confirmed
     * @return mixed
     */

    public function getAllPublic($confirmed = TRUE)
    {
        if ($confirmed == TRUE) {
            return $this->wpdb->get_col("SELECT email FROM $this->tableName WHERE active='1'");
        }
        return $this->wpdb->get_col("SELECT email FROM $this->tableName WHERE active='0'");
    }


    /**
     * Gets all Active subscribers
     *
     * @return mixed
     */

    public function getAllActive() { return $this->wpdb->get_results("SELECT * FROM $this->tableName WHERE active='1'", ARRAY_A); }


    /**
     * Gets all Inactive subscribers
     *
     * @return mixed
     */

    public function getAllInActive() { return $this->wpdb->get_results("SELECT * FROM $this->tableName WHERE active='0'", ARRAY_A); }


    /**
     * For digest function
     *
     * @return array
     */

    public function getAllActiveEmails()
    {
        $return = array();
        foreach($this->getAllActive() as $user){
            $return[] = $user['email'];
        }
        return $return;
    }


    /**
     * Gets subscribers by criteria, usealy used by exporter
     *
     * @param string $criteria
     * @return mixed
     */

    public function getByCriteria($criteria = 'all')
    {
        switch($criteria){
            case 'active':
                $return = $this->getAllActive();
                break;
            case 'inactive':
                $return = $this->getAllInActive();
                break;
            default:
            case 'all':
                $return = $this->getAll();
                break;
        }
        if(!empty($return)){
            return $return;
        } else {
            throw new SubscribersException('There are no subscribers by this criteria.');
        }
    }


    /**
     * Get's column headers for export
     *
     * @return array
     */

    public function getColumnHeaders()
    {
        $headers = array();
        foreach($this->wpdb->get_col("DESC " . $this->tableName, 0) as $columnName){
            $headers[] = $columnName;
        }
        return $headers;
    }

}

class SubscribersException extends Exception {}