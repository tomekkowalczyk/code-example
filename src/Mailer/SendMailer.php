<?php

namespace App\Mailer;

class SendMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;
    private $fromEmail;
    private $fromName;

    public function __construct(\Swift_Mailer $swiftMailer, $fromEmail, $fromName)
    {
        $this->swiftMailer = $swiftMailer;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function send(User $user, $subject, $htmlBody)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($this->fromEmail, $this->fromName)
                ->setTo($user->getEmail(), $user->getName().' '.$user->getSurname())
                ->setBody($htmlBody, 'text/html');

        return $this->swiftMailer->send($message);
    }
}
