<?php

namespace PSMAS\Common\Library\Mail;

use Phalcon\Mvc\User\Component;
use Swift_Message as Message;
use Swift_SmtpTransport as Smtp;
use Phalcon\Mvc\View;

/**
 * PSMAS\Common\Library\Mail\MailDefault
 * Sends e-mails based on pre-defined templates
 */
class MailDefault extends Component {

  /**
   * Applies a template to be used in the e-mail
   *
   * @param string $name
   * @param array $params
   * @return string
   */
  public function getTemplate($name, $params) {
    $parameters = array_merge([
      'publicUrl' => $this->config->application->publicUrl
    ], $params);

    return $this->view->getRender('emailTemplates', $name, $parameters, function ($view) {
      $view->setRenderLevel(View::LEVEL_LAYOUT);
    });

    return $view->getContent();
  }

  /**
   * Sends e-mails via AmazonSES based on predefined templates
   *
   * @param array $to
   * @param string $subject
   * @param string $name
   * @param array $params
   * @return bool|int
   * @throws Exception
   */
  public function send($to, $subject, $name, $params) {
    // Settings
    $mailSettings = $this->config->mail;

    $template = $this->getTemplate($name, $params);

    // Create the message
    $message = Message::newInstance()
      ->setSubject($subject)
      ->setTo($to)
      ->setFrom(array(
        $mailSettings->fromEmail => $mailSettings->fromName
      ))
      ->setBody($template, 'text/html');

    $this->transport = Smtp::newInstance(
      $mailSettings->smtp->server,
      $mailSettings->smtp->port
    );

    // Create the Mailer using your created Transport
    $mailer = \Swift_Mailer::newInstance($this->transport);

    return $mailer->send($message);
  }
}
