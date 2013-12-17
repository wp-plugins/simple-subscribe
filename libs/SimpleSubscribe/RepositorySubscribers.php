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


class RepositorySubscribers extends Repository
{
    /**
     * Validate API Call
     *
     * @param $id
     * @param $hash
     * @return bool
     * @throws RepositarySubscribersException
     */

    public function validateApiCall($id, $hash)
    {
        if($this->userExistsById($id)){
            return $this->checkUserHash($this->getById($id), $hash);
        } else {
            throw new RepositarySubscribersException('User does not exist.');
        }
    }


    /**
     * Is user active?
     *
     * @param $id
     * @return bool
     */

    public function isActive($id){ return $this->getVar('active', 'id', $id) == '1' ? TRUE : FALSE; }


    /**
     * Activates user
     *
     * @param $id
     * @param bool $batch
     * @return mixed
     * @throws RepositarySubscribersException
     */

    public function activateUser($id, $batch = FALSE)
    {
        if($this->isActive($id) && $batch == FALSE){
            throw new RepositarySubscribersException('This subscriber was already active!');
        } else {
            return $this->update(array('active' => '1'), array( 'id' => $id));
        }
    }


    /**
     * Deactivates user
     *
     * @param $id
     * @param bool $batch
     * @return mixed
     * @throws RepositarySubscribersException
     */

    public function deactivateUser($id, $batch = FALSE)
    {
        if($this->isActive($id)){
            return $this->update(array('active' => '0'), array( 'id' => $id));
        } elseif ($batch == FALSE){
            throw new RepositarySubscribersException('This subscriber was already inactive!');
        }
    }


    /**
     * Activates batch
     *
     * @param array $batch
     */

    public function activateBatch(array $batch){ foreach($batch as $id){ $this->activateUser($id, TRUE); } }



    /**
     * Deactivates batch
     *
     * @param array $batch
     */

    public function deactivateBatch(array $batch){ foreach($batch as $id){ $this->deactivateUser($id, TRUE); } }


    /**
     * Deletes user
     *
     * @param $id
     * @return mixed
     */

    public function deleteUser($id){ return $this->delete(array('id' => $id)); }


    /**
     * Deletes batch
     *
     * @param array $batch
     */

    public function deleteBatch(array $batch){ foreach($batch as $id){ $this->deleteUser($id); } }


    /**
     * Decides what to do, deactivate, or delete? according to settings in admin
     *
     * @param $email
     */

    public function deleteOrDeactivateByEmail($email)
    {
        $delete = isset($this->settingsAll['misc']['deactivation']) ? ($this->settingsAll['misc']['deactivation'] == 0 ? TRUE : FALSE) : TRUE;
        if(email_exists($email)){
            // registered users can unsubscribe in their profile
            throw new RepositarySubscribersException('Registered users can unsubscribe in their Wordpress admin profile.');
        } else {
            // subscribers
            if($delete == TRUE){
                $this->deleteUserByEmail($email);
            } else {
                $this->deactivateUserByEmail($email);
            }
        }
    }


    /**
     * Used by API
     *
     * @param $email
     * @throws RepositarySubscribersException
     */

    public function deleteUserByEmail($email)
    {
        if($this->userByEmailExists($email)){
            $this->deleteUser($this->getUserIdByEmail($email));
        } else {
            throw new RepositarySubscribersException('User with this e-mail address does not exist!');
        }
    }


    /**
     * Used by API
     *
     * @param $email
     * @throws RepositarySubscribersException
     */

    public function deactivateUserByEmail($email)
    {
        if($this->userByEmailExists($email)){
            $this->deactivateUser($this->getUserIdByEmail($email));
        } else {
            throw new RepositarySubscribersException('User with this e-mail address does not exist!');
        }
    }


    /**
     * Get user by id
     *
     * @param int $id
     * @return bool|mixed
     */

    public function getById($id = 0)
    {
        if (!$id){ return false; }
        return $this->getVar('email', 'id', $id);
    }


    /**
     * Get user by email addresss
     *
     * @param $email
     * @return bool|mixed
     */

    public function getUserIdByEmail($email)
    {
        if (!$email){ return false; }
        return $this->getVar('id', 'email', $email);
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

    public function getUserHash($email) { return sha1($this->tableName . $email); }


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
            throw new RepositarySubscribersException('We are really sorry, but user with this e-mail address already exists.',0);
        } else {
            $data->active = 0;
            $data->ip = \SimpleSubscribe\Utils::getRealIp();
            if($this->insert($data)){
                try{
                    $email = \SimpleSubscribe\Email::getInstance();
                    $email->sendConfiramtionEmail($data->email,  $this->database->insert_id);
                } catch (EmailException $e){
                    throw new RepositarySubscribersException($e->getMessage());
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
            throw new RepositarySubscribersException('We are really sorry, but user with this e-mail address already exists.', 0);
        } else {
            return $this->database->insert($this->tableName, (array)$data);
        }
    }


    /**
     * Adds registered users
     *
     * @param array $ids
     * @throws RepositarySubscribersException
     */

    public function addWpRegistered(array $ids)
    {
        if(!is_array($ids) || empty($ids)){ throw new RepositarySubscribersException('No users given.'); }
        foreach($ids as $id){
            $this->activateRegisteredUserById($id);
        }
    }


    /**
     * Returns register and active users
     *
     * @return array
     */

    public function getAllRegistered()
    {
        $return = array();
        $registeredUsers = get_users(array('meta_key' => 'subscription', 'meta_value' => 1));
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
     * Get's all WP users, that are not subscribed
     *
     * @return array
     */

    public function getAllRegisteredInactive()
    {
        $return = array();
        $registeredUsers = get_users(array('fields' => 'all_with_meta'));
        if(!empty($registeredUsers)){
            foreach($registeredUsers as $user){
                $subscription = get_user_meta($user->data->ID, 'subscription', TRUE);
                if(empty($subscription)){
                    $return[$user->data->ID] = $user->data->display_name . ' - ' . $user->data->user_email;
                }
            }
        }
        return $return;
    }


    /**
     * Get's all registered e-mail addresses
     *
     * @return array
     */

    public function getAllRegisteredActiveEmails()
    {
        $return = array();
        $registeredUsers = get_users(array('meta_key' => 'subscription', 'meta_value' => 1));
        if(!empty($registeredUsers)){
            foreach($registeredUsers as $user){
                $return[] = $user->data->user_email;
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
     * Adds registered user to subscription
     *
     * @param $id
     * @return mixed
     */

    public function activateRegisteredUserById($id){ return update_user_meta($id, 'subscription', 1); }


    /**
     * Returns registered user by id
     *
     * @param $id
     * @return mixed
     */

    public function getRegisteredUserById($id){ return $this->getVar('email', 'id', $id, $this->database->users); }


    /**
     * Get all subscribers, for export, list table
     */

    public function getAllSubscribers(){ return array_merge($this->getAll(), $this->getAllRegistered()); }


    /**
     * Get all public subcribers
     *
     * @param int $confirmed
     * @return mixed
     */

    public function getAllPublic($confirmed = TRUE)
    {
        if ($confirmed == TRUE){
            return $this->get('email', 'active', 1);
        }
        return $this->get('email', 'active', 0);
    }


    /**
     * Gets all Active subscribers
     *
     * @return mixed
     */

    public function getAllActive(){ return array_merge($this->getAllWhere('active', 1), $this->getAllRegistered()); }


    /**
     * Gets all Inactive subscribers
     *
     * @return mixed
     */

    public function getAllInActive(){ return $this->getAllWhere('active', 0); }


    /**
     * Get all active e-mails - without wordpress users.
     *
     * @return array
     */

    public function getAllActiveNonWpEmails()
    {
        $return = array();
        foreach($this->getAllWhere('active', 1) as $user){
            $return[] = $user['email'];
        }
        return $return;

    }

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
                $return = $this->getAllSubscribers();
                break;
        }
        if(!empty($return)){
            return $return;
        } else {
            throw new RepositarySubscribersException('There are no subscribers by this criteria.');
        }
    }
}

class RepositarySubscribersException extends \Exception {}