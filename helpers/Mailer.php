<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 *
 * This helper class will contain
 * everything related to sending emails
 *
 * Runs on PHP Mailer v5.2.16
 */

class Mailer {
    /**
     * @var Object
     *
     * This variable will contain
     * the PHPMailer object
     */
    public $mail;

    public function __construct() {
        /**
         * Initialize the PHPMailer framework
         */
        $this->mail = new PHPMailer();
    }

    /**
     * @param $email
     * @param $name
     * @throws phpmailerException
     */
    public function set_from($email, $name = null) {
        $this->mail->setFrom($email, $name);
    }

    /**
     * @param $email
     * @param null $name
     */
    public function add_address($email, $name = null) {
        $this->mail->addAddress($email, $name);
    }

    /**
     * @param $email
     * @param null $info
     */
    public function add_reply($email, $info = null) {
        $this->mail->addReplyTo($email, $info);
    }

    /**
     * @param $email
     */
    public function add_CC($email) {
        $this->mail->addCC($email);
    }

    /**
     * @param $email
     */
    public function add_BCC($email) {
        $this->mail->addBCC($email);
    }

    /**
     * @param $attachment
     * @throws phpmailerException
     */
    public function add_attach($attachment) {
        $this->mail->addAttachment($attachment);
    }

    /**
     * @param bool $isHTML
     */
    public function set_isHTML($isHTML = true) {
        $this->mail->isHTML($isHTML);
    }

    /**
     * @param $subject
     */
    public function set_subject($subject) {
        $this->mail->Subject = $subject;
    }

    /**
     * @param $body
     */
    public function set_body($body) {
        $this->mail->Body = $body;
    }

    /**
     * @param $altbody
     */
    public function set_altbody($altbody) {
        $this->mail->AltBody = $altbody;
    }

    /**
     * Sends the email
     */
    public function send_mail() {
        if (!$this->mail->send()) {
            Debug::exitdump("Email could not send: " . $this->mail->ErrorInfo, __LINE__, "helpers/Mailer");
        }
    }
}