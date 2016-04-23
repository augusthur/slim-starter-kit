<?php namespace App\Util;

class SwiftMailerService {

    private $mailer;
    
    public function __construct($mode, $transport, $options)
    {
        if ($mode == 'dev') {
            $transport = \Swift_NullTransport::newInstance();
        } elseif ($transport == 'smtp') {
            $transport = \Swift_SmtpTransport::newInstance($options['host'], $options['port'])
                ->setUsername($options['username'])
                ->setPassword($options['password']);
        } elseif ($transport == 'sendmail') {
            $transport = \Swift_SendmailTransport::newInstance($options['command']);
        } elseif ($transport == 'mail') {
            $transport = \Swift_MailTransport::newInstance();
        }
        $this->mailer = \Swift_Mailer::newInstance($transport);
    }

    public function send($message)
    {
        return $this->mailer->send($message);
    }

    public function sendMail($subject, $to, $body)
    {
        $message = \Swift_Message::newInstance($subject)->setTo($to);
        if (is_array($body)) {
            $first = true;
            foreach ($body as $part) {
                if ($first) {
                    $message->setBody($part);
                    $first = false;
                } else {
                    $message->addPart($part);
                }
            }
        } else {
            $message->setBody($body);
        }
        return $this->send($message);
    }
    
    public function getMailer()
    {
        return $this->mailer;
    }
}
