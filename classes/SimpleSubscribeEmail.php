<?php
if (!defined('ABSPATH')) { exit; }

use Nette\Mail\Message,
    Nette\Mail\SendmailMailer,
    Nette\Utils\Html;

class SimpleSubscribeEmail extends Nette\Object
{
    /** @var bool */
    private static $instance = false;
    /** @var string */
    var $senderName;
    /** @var string */
    var $senderEmail;
    /** @var \SimpleSubscribeSettings */
    var $settings;
    /** @var bool|\SimpleSubscribeSubscribers */
    var $subscribers;
    /** @var \Nette\Mail\SendmailMailer */
    var $mailer;


    /**
     * Constructor
     *
     * @param null $senderName
     * @param null $senderEmail
     */

    public function __construct($senderName = NULL, $senderEmail = NULL)
    {
        $this->senderName   = $senderName ? $senderName : html_entity_decode(get_option('blogname'), ENT_QUOTES);
        $this->senderEmail  = $senderEmail ? $senderEmail : get_option('admin_email');
        $this->settings     = new SimpleSubscribeSettings(SUBSCRIBE_KEY);
        $this->subscribers  = SimpleSubscribeSubscribers::getInstance();
        $this->mailer       = new \Nette\Mail\SendmailMailer();
    }


    /**
     * @return bool|SimpleSubscribeEmail
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
        // prepare social links
        $settings = $this->settings->getSettings();
        $settingsSocial = isset($settings['social']) ? $settings['social'] : array();
        // defaults
        $defaults = array(
            'subject' => '',
            'homeUrl' => '',
            'image' => $this->senderName, // for now blog_name
            'message' => '',
            'social' => $settingsSocial,
            'unSubscribe' => Html::el('a')->href(SUBSCRIBE_API_URL)->setText('Unsubscribe here.')
        );
        $template = new SimpleSubscribeTemplate('email.latte');
        $template->prepareTemplate($defaults, $data);
        return $template->getTemplate();
    }


    /**
     * Test
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

    private function sendEmail($recipients = array(), $subject = NULL, $data)
    {
        // recipients check
        if(count($recipients) > 0){
            $emailTo = $recipients[0];
            unset($recipients[0]);
        } else {
            throw new EmailException('No recipients provided.');
        }
        // try sending e-mail
        try{
            $mail = new Nette\Mail\Message;
            $mail->setFrom($this->senderEmail, $this->senderName)
                ->addTo($emailTo)
                ->setSubject($subject);
            if(count($recipients > 0)){
                foreach($recipients as $recipient){
                    $mail->addCc($recipient);
                }
            }
            $mail->setHTMLBody($this->getEmailTemplate($data));
            $this->mailer->send($mail);
        } catch(Exception $e){
            throw new EmailException($e->getMessage());
        }
    }


    /**
     * Get's confirmation e-mail body.
     *
     * @param $email
     * @return stdClass
     */

    public function getConfirmationEmailBody($email, $id)
    {
        $return = new stdClass();
        $emailUrlQuery = array(
            SUBSCRIBE_KEY => 1,
            'a' => 's',
            'sb' => $this->subscribers->getUserHash($email),
            'i' => $id
        );
        $emailLink = Html::el('a')->href(SUBSCRIBE_HOME_URL, $emailUrlQuery)->setText('here.');
        $emailBody = 'To finish your subscription, you need to confirm your e-mail address '. $emailLink .'';
        $return->subject = 'Subscription confirmation';
        $return->data = array(
            'subject' => $return->subject,
            'message' => $emailBody,
            'unSubscribe' => ''
        );
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
        $return = new stdClass();

        $postLink = get_permalink($post->ID);
        $postExcerpt = $this->createPostDigestExcerpt($post->post_content, 20);
        $postTitle = $post->post_title;
        $postImage = wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'simpleSubscribeEmail');

        $emailBody = Html::el('table border="0" cellpadding="0" cellspacing="0" width="100%"')
        ->add(
            Html::el('tr')->add(
                Html::el('td style="width: 70%"')
                    ->add(Html::el('h3')->setText($post->post_title))
                    ->add(Html::el('p')->setText($this->createPostDigestExcerpt($post->post_content, 20))
                    ->add(Html::el('p')
                        ->add(Html::el('a class="more"')->href(get_permalink($post->ID))->setHtml('Read more &hellip;')))
            )->add(
                Html::el('td style="width: 30%"')->setHtml(wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'simpleSubscribeEmail')))
            )
        );

        $return->subject = 'New Post from ' . $this->senderName;
        $return->data = array(
            'subject' => $return->subject,
            'message' => $emailBody,
        );

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
        if(!$post){ throw new EmailException('No post to send!'); }
        $subcribers = $this->subscribers->getAllActiveEmails();
        $postDigest = $this->getPostDigestBody($post);
        $this->sendEmail($subcribers, $postDigest->subject, $postDigest->data);
    }


    /**
     * Digest helper
     *
     * @param $postContent
     * @param int $length
     * @return string
     */

    public function createPostDigestExcerpt($postContent, $length = 35)
    {
        $postContent = strip_tags(strip_shortcodes($postContent));
        if(mb_strlen($postContent, 'UTF-8') > $length){
            return mb_substr($postContent, 0, $length, 'UTF-8') . '&hellip;';
        }
        return $postContent;
    }
}

class EmailException extends Exception{}