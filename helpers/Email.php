<?php
class Email {
    /**
     * This helper class will contain
     * everything related to sending emails
     * 
     * TODO: Add PHP Mailer to Snail - PHP Framework
     */

    /**
     * @param $email
     * @param $name
     * @param $password
     * @param $hash
     * @return bool
     *
     * Static method to send verification email after registration
     * This can only be used if the website is hosted
     */
    public static function send_verification_email($email, $name, $password, $hash) {
        /**
         * @var String
         */
        $to = $email;

        /**
         * @var String
         */
        $subject = 'Signup | Verification';

        /**
         * @var String
         *
         * Contains email content
         */
        $message = '
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

Username: ' . $name. '
Password: ' . str_repeat ('*', strlen ($password)) . '

Please click this link to activate your account:
http://www.Snail_MVC.com/verify?email=' . $email . '&hash=' . $hash . '';

        /**
         * @var String
         */
        $headers = 'From:noreply@yourwebsite.com' . "\r\n";

        /**
         * If the website is hosted you could set the result
         * variable as follows:
         *
         * $result = mail($to, $subject, $message, $headers);
         */

        return $result = true;
    }
}