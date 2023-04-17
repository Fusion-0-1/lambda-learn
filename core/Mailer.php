<?php

namespace app\core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php';

class Mailer
{
    private static $instance = null;
    private PHPMailer $mail;
    private string $host;
    private int $port;
    private string $encryption;
    private string $username;
    private string $password;
    private string $fromEmail;
    private string $fromName;


    private function __construct($config)
    {
        //Set who the message is to be sent from
        $this->host = $config['host'];
        $this->port = (int)$config['port'];
        $this->encryption = $config['encryption'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->fromEmail = $config['from'];
        $this->fromName = $config['from_name'];
    }

    public static function getMailerInstance($config): Mailer
    {
        if (!isset(static::$instance)) {
            static::$instance = new Mailer($config);
        }
        return static::$instance;
    }

    public function sendAccountCreateMail(User $user, $password): void
    {
        $email_vars = array(
            'user' => $user->getFullName(),
            'username' => $user->getRegNo(),
            'password' => $password,
        );
        $this->sendMail(
            'Lambda-Learn Account Information',
            '../Emails/account_creation.html',
            '/Emails/',
            $user->getPersonalEmail(),
            $user->getFullName(),
            $email_vars
        );
    }


    private function sendMail(
        $subject, $htmlTemplateFile, $templateDirectory, $toEmail, $toName, $emailVars)
    {
        //Create a new PHPMailer instance
        $this->mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $this->mail->isSMTP();

        //Enable SMTP debugging
        //SMTP::DEBUG_OFF = off (for production use)
        //SMTP::DEBUG_CLIENT = client messages
        //SMTP::DEBUG_SERVER = client and server messages
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;

        //Set the hostname of the mail server
        $this->mail->Host = $this->host;
        //Use `$this->mail->Host = gethostbyname('smtp.gmail.com');`
        //if your network does not support SMTP over IPv6,
        //though this may cause issues with TLS

        //Set the SMTP port number:
        // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
        // - 587 for SMTP+STARTTLS
        $this->mail->Port = $this->port;

        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $this->mail->SMTPSecure =
            $this->encryption == 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;

        //Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $this->mail->Username = $this->username;

        //Password to use for SMTP authentication
        $this->mail->Password = $this->password;

        //Set who the message is to be sent from
        //Note that with gmail you can only use your account address (same as `Username`)
        //or predefined aliases that you have configured within your account.
        //Do not use user-submitted addresses in here
        $this->mail->setFrom($this->fromEmail, $this->fromName);

        //Set an alternative reply-to address
        //This is a good place to put user-submitted addresses
//        $this->mail->addReplyTo('replyto@example.com', 'First Last');

        //Set who the message is to be sent to
        $this->mail->addAddress($toEmail, $toName);

        //Set the subject line
        $this->mail->Subject = $subject;

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $body = file_get_contents($htmlTemplateFile);

        if(isset($emailVars)){
            foreach($emailVars as $k=>$v){
                $body = str_replace('['.strtoupper($k).']', $v, $body);
            }
        }
        $this->mail->msgHTML($body, $templateDirectory);
//        $this->mail->Body = 'This is the HTML message body <b>in bold!</b>';

        //Replace the plain text body with one created manually
//        $this->mail->AltBody = 'This is a plain-text message body';

        //Attach an image file
//        $this->mail->addAttachment('images/phpmailer_mini.png');

        $this->mail->send();
        //send the message, check for errors
//        if (!$this->mail->send())
//        {
//            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
//        }
//
//        else {
//            echo 'Message sent!';
//        }
    }
}