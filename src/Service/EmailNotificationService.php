<?php

namespace Drupal\ed_classified\Service;

use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\node\Entity\Node;

/**
 * Service to handle email notifications for classified ads.
 */
class EmailNotificationService {

  use StringTranslationTrait;

  /**
   * The mail manager service.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * The language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Constructs a new EmailNotificationService object.
   *
   * @param \Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   The mail manager service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager service.
   */
  public function __construct(MailManagerInterface $mail_manager, LanguageManagerInterface $language_manager) {
    $this->mailManager = $mail_manager;
    $this->languageManager = $language_manager;
  }

  /**
   * Sends an email notification when a classified ad is posted.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The classified ad node entity.
   */
  public function sendAdPostedNotification(Node $node) {
    $to = $node->getOwner()->getEmail(); // Get the email of the user who posted the ad
    $subject = $this->t('Your Classified Ad Has Been Posted');
    $message = $this->t('Your classified ad titled "@title" has been successfully posted on our site.', ['@title' => $node->getTitle()]);
    
    $this->sendEmail($to, $subject, $message);
  }

  /**
   * Sends an email notification when a classified ad is about to expire.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The classified ad node entity.
   */
  public function sendAdExpiryNotification(Node $node) {
    $to = $node->getOwner()->getEmail();
    $subject = $this->t('Your Classified Ad is About to Expire');
    $message = $this->t('Your classified ad titled "@title" is about to expire. Please renew it to keep it active.', ['@title' => $node->getTitle()]);
    
    $this->sendEmail($to, $subject, $message);
  }

  /**
   * Sends an email notification for any other condition.
   *
   * @param string $to
   *   The email address to send the notification to.
   * @param string $subject
   *   The subject of the email.
   * @param string $message
   *   The message body of the email.
   */
  public function sendCustomNotification($to, $subject, $message) {
    $this->sendEmail($to, $subject, $message);
  }

  /**
   * A helper function to send the email.
   *
   * @param string $to
   *   The recipient's email address.
   * @param string $subject
   *   The email subject.
   * @param string $message
   *   The email message body.
   */
  protected function sendEmail($to, $subject, $message) {
    $params = [
      'subject' => $subject,
      'message' => $message,
    ];

    // Send email using the mail manager
    $this->mailManager->mail('ed_classified', 'notification', $to, $this->languageManager->getDefaultLanguage()->getId(), $params);
  }
}
