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

use Nette\Mail\Message,
    Nette\Mail\SendmailMailer,
    Nette\Utils\Strings,
    Nette\Utils\Html;


class Email extends \Nette\Object
{
    /** @var bool */
    private static $instance = false;
    /** @var string */
    var $senderName;
    /** @var string */
    var $senderEmail;
    /** @var \SimpleSubscribeSettings */
    var $settings;
    /** @var mixed */
    var $settingsAll;
    /** @var bool */
    var $htmlEmail;
    /** @var bool|\RepositorySubscribers */
    var $subscribers;
    /** @var \RepositoryLog */
    var $log;
    /** @var \Nette\Mail\SendmailMailer */
    var $mailer;


    /**
     * Constructor
     */

    public function __construct()
    {
        $this->settings     = new \SimpleSubscribe\Settings(SUBSCRIBE_KEY);
        $this->settingsAll  = $this->settings->getSettings();
        $this->htmlEmail    = isset($this->settingsAll['emailType']['source']) ? ($this->settingsAll['emailType']['source'] == 0 ? TRUE : FALSE) : TRUE;
        $this->subscribers  = \SimpleSubscribe\RepositorySubscribers::getInstance();
        $this->log          = \SimpleSubscribe\RepositoryLog::getInstance();
        $this->mailer       = new \Nette\Mail\SendmailMailer();
        $this->senderName   = isset($this->settingsAll['misc']['senderName']) ? $this->settingsAll['misc']['senderName'] : html_entity_decode(get_option('blogname'), ENT_QUOTES);
        $this->senderEmail  = isset($this->settingsAll['misc']['senderEmail']) ? $this->settingsAll['misc']['senderEmail'] : get_option('admin_email');
    }


    /**
     * @return bool|Email
     */

    public static function getInstance()
    {
        if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * Prepare template
     *
     * @param string $templateFile
     * @param array $data
     * @return Nette\Templating\FileTemplate
     */

    public function getEmailTemplate($data = array())
    {
        // prepare social links and colours
        $settingsSocial = isset($this->settingsAll['social']) ? $this->settingsAll['social'] : array();
        $settingsColours = isset($this->settingsAll['emailDesign']) ? $this->settingsAll['emailDesign'] : array();
        $defaultColours = array('colourBodyBg' => '#ececec', 'colourBg' => '#f5f5f5','colourTitle' => '#000000', 'colourLinks' => '#000000');
        // which template file are we using?
        $templateFile = $this->htmlEmail ? 'email.latte' : 'emailPlain.latte';
        // defaults
        $defaults = array(
            'subject'   => '',
            'homeUrl'   => '',
            'image'     => $this->senderName,
            'message'   => '',
            'social'    => $settingsSocial,
            'colours'   => array_merge($defaultColours, $settingsColours),
            'unSubscribe'   => Html::el('a')->href(SUBSCRIBE_API_URL)->setText('Unsubscribe here.')
        );

        // prepare template
        $template = new \SimpleSubscribe\Template($templateFile);
        $template->prepareTemplate($defaults, $data);

        // convert to string if needed
        if($this->htmlEmail != TRUE){
            $templatePlain = new \SimpleSubscribe\Html2Text($template->getTemplate());
            return $templatePlain->get_text();
        }
        return $template->getTemplate();
    }


    /**
     * Send email preview
     *
     * @param $email
     */

    public function sendEmailPreview($formValues)
    {
        // preview data
        $previewPostId = $this->randomPostId();

        if(!empty($previewPostId)){
            if($formValues['post'] == 1){
                $previewDigest = $this->getPostDigestBody(get_post($this->randomPostId()));
                $this->sendEmail(array($formValues['email']), $previewDigest->subject, $previewDigest->data);
            }
        } else {
            throw new EmailException('No post to create preview from found.');
        }
        if($formValues['subscription'] == 1){
            $previewConfirm = $this->getConfirmationEmailBody($formValues['email'], 1);
            $this->sendEmail(array($formValues['email']), $previewConfirm->subject, $previewConfirm->data);
        }

    }


    /**
     * Mass email handler
     *
     * @param $formValues
     * @throws EmailException
     */

    public function sendMassEmail($formValues)
    {
        $email = $this->getSimpleEmailBody($formValues['subject'], $formValues['body']);
        switch($formValues['emailWho']){
            case 1:
                // All subscriber(s)
                $this->sendEmail($this->subscribers->getAllActiveEmails(), $email->subject, $email->data);
                break;
            case 2:
                // Single subscriber
                if(!empty($formValues['email'])){
                    $this->sendEmail(array($formValues['email']), $email->subject, $email->data);
                } else {
                    throw new EmailException('No e-mail address provided');
                }
                break;
            case 3:
                // Wordpress Registered subscribers
                $this->sendEmail($this->subscribers->getAllRegisteredActiveEmails(), $email->subject, $email->data);
                break;
            case 4:
                // Non-wordpress Registered subscribers
                $this->sendEmail($this->subscribers->getAllActiveNonWpEmails(), $email->subject, $email->data);
        }
    }


    /**
     * Random post id
     *
     * @return mixed
     */

    private function randomPostId()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT id FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY RAND()");
    }


    /**
     * Does what it says brother, trust me.
     *
     * @param $email
     */

    public function sendConfiramtionEmail($email, $id)
    {
        $confirmation = $this->getConfirmationEmailBody($email, $id);
        $this->sendEmail(array($email), $confirmation->subject, $confirmation->data);
    }


    /**
     * Here's the magic
     *
     * @param array $recipients
     * @param null $subject
     * @param array $data
     * @throws EmailException
     */

    private function sendEmail($recipients = array(), $subject = '', $data)
    {
        // recipients check
        if(!is_array($recipients)){ $recipients = array($recipients); }
        if(count($recipients) < 1){
            throw new EmailException('No subscribers provided. (possibly none in your system)');
        }
        // try sending e-mail
        try{
            $mail = new \Nette\Mail\Message;
            $mail->setFrom($this->senderEmail, $this->senderName)->setSubject($subject);
            foreach($recipients as $recipient){
                $mail->addBcc($recipient);
            }
            // set HTML / or plaintext body
            if($this->htmlEmail == TRUE){
                $mail->setHTMLBody($this->getEmailTemplate($data));
            } else {
                $mail->setBody($this->getEmailTemplate($data));
            }
            $this->mailer->send($mail);
        } catch(\Exception $e){
            throw new EmailException($e->getMessage());
        }
    }


    /**
     * Get's confirmation e-mail body.
     *
     * @param $email
     * @return \stdClass
     */

    public function getConfirmationEmailBody($email, $id)
    {
        $return = new \stdClass();
        $emailUrlQuery = array(
            SUBSCRIBE_KEY => 1,
            'a' => 's',
            'sb' => $this->subscribers->getUserHash($email),
            'i' => $id
        );
        $emailLink = Html::el('a')->href(SUBSCRIBE_HOME_URL, $emailUrlQuery)->setText('here.');
        $emailBody = 'To finish your subscription, you need to confirm your e-mail address '. $emailLink .'';
        // only add this to HTML mails, possible link that could have been stripped down in some e-mail clients.
        if($this->htmlEmail == TRUE){
            $emailBody .= '<br /><br />';
            $emailBody .= '<small>If you can\'t click the link above, copy and paste this url into your browser: ' . $emailLink->href .'</small>';
        }
        $return->subject = 'Subscription confirmation';
        $return->data = array(
            'subject' => $return->subject,
            'message' => $emailBody,
            'unSubscribe' => ''
        );
        return $return;
    }


    /**
     * Simple email body
     *
     * @param $subject
     * @param $body
     * @return \stdClass
     */

    public function getSimpleEmailBody($subject, $body)
    {
        $return = new \stdClass();
        $return->data = array('subject' => $subject, 'message' => $body, 'unSubscribe' => '');
        $return->subject = isset($subject) ? $subject : '';
        return $return;
    }


    /**
     * Post Digest
     *
     * @param $post
     * @return string
     */

    public function getPostDigestBody($post)
    {
        // if not set, go with excerpt with featured 0: Short Excerpt, 1: Short Excerpt with Featured image, 2: Full post
        $digestType = isset($this->settingsAll['emailType']['type']) ? $this->settingsAll['emailType']['type'] : 0;
        //  0: New Post from, 1: POST_TITLE by, 2: POST_TITLE
        $digestSubject = isset($this->settingsAll['misc']['emailSubject']) ? $this->settingsAll['misc']['emailSubject'] : 0;

        // prepare return
        $return = new \stdClass();

        // post variables
        $postLink = get_permalink($post->ID);
        $postExcerpt = (isset($post->post_excerpt) && (!empty($post->post_excerpt))) ? $post->post_excerpt : $this->createPostDigestExcerpt($post->post_content, 350);
        $postTitle = $post->post_title;
        $postImage = wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'simpleSubscribeEmail');

        // digest subject
        switch($digestSubject){
            case 0:
            default:
                $return->subject = 'New Post from ' . $this->senderName;
                break;
            case 1:
                $return->subject = $post->post_title . ' by ' . $this->senderName;
                break;
            case 2:
                $return->subject = $post->post_title;
                break;
        }

        // digest type
        switch($digestType){
            case 0:
                $emailBody = Html::el('table border="0" cellpadding="0" cellspacing="0" width="100%"')
                    ->add(
                    Html::el('tr')->add(
                        Html::el('td style="width: 100%"')
                            ->add(Html::el('h3')->setText($post->post_title))
                            ->add(Html::el('p')->setText($postExcerpt)
                                ->add(Html::el('p')
                                ->add(Html::el('a class="more"')->href(get_permalink($post->ID))->setHtml('Read more &hellip;')))
                        )
                    )
                );
                break;
            case 1:
            default:
                $emailBody = Html::el('table border="0" cellpadding="0" cellspacing="0" width="100%"')
                    ->add(
                    Html::el('tr')->add(
                        Html::el('td style="width: 70%"')
                            ->add(Html::el('h3')->setText($post->post_title))
                            ->add(Html::el('p')->setText($postExcerpt)
                                ->add(Html::el('p')
                                ->add(Html::el('a class="more"')->href(get_permalink($post->ID))->setHtml('Read more &hellip;')))
                        )->add(
                            Html::el('td style="width: 30%"')->setHtml(wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'simpleSubscribeEmail')))
                    )
                );
                break;
            case 2:
                $emailBody = Html::el('table border="0" cellpadding="0" cellspacing="0" width="100%"')
                    ->add(
                    Html::el('tr')->add(
                        Html::el('td style="width: 70%"')
                            ->add(Html::el('h3')->setText($post->post_title))
                            ->add(Html::el('div')->setHtml(Utils::getPostContent($post->ID)))
                    )
                );
                break;
        }

        if($this->htmlEmail == TRUE){
            $emailBody .= '<br /><br />';
            $emailBody .= '<small>If you can\'t click the link above, copy and paste this url into your browser: ' . $postLink .'</small>';
        }

        // return
        $return->data = array('subject' => $return->subject, 'message' => $emailBody);

        return $return;
    }


    /**
     * On post publish
     *
     * @param $post
     * @return mixed
     */

    public function onPublish($post)
    {
        if($post){
            $subcribers = $this->subscribers->getAllActiveEmails();
            $postDigest = $this->getPostDigestBody($post);
            try {
                $this->sendEmail($subcribers, $postDigest->subject, $postDigest->data);
                // log success message
                $this->log->add(1, 'Digest successfully sent to ' . count($subcribers) . ' subscribers. Post ID: ' . $post->ID);
            } catch (EmailException $e){
                // log error
                $this->log->add(0, $e->getMessage());
            }
        } else {
            // log error
            $this->log->add(0, 'Digest not sent - no post included. Removed maybe?');
        }
    }


    /**
     * Digest helper
     *
     * @param $postContent
     * @param int $length
     * @return string
     */

    public function createPostDigestExcerpt($postContent, $length = 135)
    {
        $postContent = strip_tags(strip_shortcodes($postContent));
        $postContent = \Nette\Utils\Strings::fixEncoding($postContent);
        return \Nette\Utils\Strings::truncate($postContent, $length);
    }
}

class EmailException extends \Exception{}