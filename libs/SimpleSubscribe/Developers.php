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

class Developers extends \Nette\Object
{
    /**
     * Subscription form
     *Polka Dot Blouse
     * @return Nette\Forms\Form
     */

    public static function getSubscriptionForm()
    {
        $settings = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
        $form = \SimpleSubscribe\Forms::subscriptionForm($settings->getTableColumns());
        if ($form->isSubmitted() && $form->isValid()){
            try{
                $subscribers = \SimpleSubscribe\RepositorySubscribers::getInstance();
                $subscribers->add($form->getValues());
                $form->setValues(array(),TRUE);
            } catch (RepositarySubscribersException $e){
                $form->addError($e->getMessage());
            }
        }
        return $form;
    }


    /**
     * Unsubscription form
     *
     * @return Nette\Forms\Form
     */

    public static function getUnsubscriptionForm()
    {
        $form = \SimpleSubscribe\Forms::unsubscriptionForm();
        if ($form->isSubmitted() && $form->isValid()){
            try {
                $subscribers = \SimpleSubscribe\RepositorySubscribers::getInstance();
                $formValues = $form->getValues();
                $subscribers->deleteOrDeactivateByEmail($formValues->email);
                $form->setValues(array(),TRUE);
            } catch (RepositarySubscribersException $e){
                $form->addError($e->getMessage());
            }
        }
        return $form;
    }
}