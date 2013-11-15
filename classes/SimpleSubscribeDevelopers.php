<?php
if (!defined('ABSPATH')) { exit; }


class SimpleSubscribeDevelopers extends Nette\Object
{
    /**
     * Subscription form
     *
     * @return Nette\Forms\Form
     */

    public static function getSubscriptionForm()
    {
        $settings = new SimpleSubscribeSettings(SUBSCRIBE_KEY);
        $form = SimpleSubscribeForms::subscriptionForm($settings->getTableColumns());
        if ($form->isSubmitted() && $form->isValid()){
            try{
                $subscribers = SimpleSubscribeSubscribers::getInstance();
                $subscribers->add($form->getValues());
                $form->setValues(array(),TRUE);
            } catch (SubscribersException $e){
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
        $form = SimpleSubscribeForms::unsubscriptionForm();
        if ($form->isSubmitted() && $form->isValid()){
            try {
                $subscribers = SimpleSubscribeSubscribers::getInstance();
                $formValues = $form->getValues();
                $subscribers->deleteUserByEmail($formValues->email);
                $form->setValues(array(),TRUE);
            } catch (SubscribersException $e){
                $form->addError($e->getMessage());
            }
        }
        return $form;
    }
}