namespace Drupal\ed_classified\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldableEntityInterface;
use Drupal\ed_classified\Entity\ClassifiedAdInterface;

/**
 * Defines the Classified Ad entity.
 *
 * @ContentEntityType(
 *   id = "classified_ad",
 *   label = @Translation("Classified Ad"),
 *   base_table = "classified_ad",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title"
 *   },
 *   fieldable = TRUE,
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "form" = {
 *       "default" = "Drupal\ed_classified\Form\ClassifiedAdForm",
 *       "add" = "Drupal\ed_classified\Form\ClassifiedAdForm",
 *       "edit" = "Drupal\ed_classified\Form\ClassifiedAdForm",
 *     },
 *     "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   links = {
 *     "canonical" = "/classified-ad/{classified_ad}",
 *     "add-form" = "/classified-ad/add",
 *   },
 *   field_ui_base_route = "entity.classified_ad.settings"
 * )
 */
class ClassifiedAd extends ContentEntityBase implements ClassifiedAdInterface {

  /**
   * {@inheritdoc}
   */
  public function getExpirationDate() {
    return $this->get('field_expiration_date')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setExpirationDate($date) {
    $this->set('field_expiration_date', $date);
  }

  /**
   * {@inheritdoc}
   */
  public function getPaymentStatus() {
    return $this->get('field_payment_status')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setPaymentStatus($status) {
    $this->set('field_payment_status', $status);
  }

  /**
   * {@inheritdoc}
   */
  public function getAdStatus() {
    return $this->get('field_ad_status')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setAdStatus($status) {
    $this->set('field_ad_status', $status);
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add Expiration Date field.
    $fields['field_expiration_date'] = FieldDefinitionInterface::create('datetime')
      ->setLabel(t('Expiration Date'))
      ->setRequired(TRUE)
      ->setDescription(t('The date when the classified ad will expire.'));

    // Add Payment Status field.
    $fields['field_payment_status'] = FieldDefinitionInterface::create('boolean')
      ->setLabel(t('Payment Status'))
      ->setRequired(TRUE)
      ->setDescription(t('Indicates if the classified ad has been paid.'));

    // Add Ad Status field.
    $fields['field_ad_status'] = FieldDefinitionInterface::create('list_string')
      ->setLabel(t('Ad Status'))
      ->setRequired(TRUE)
      ->setDescription(t('The current status of the ad (Active, Expired, On Hold).'))
      ->setSetting('allowed_values', [
        'active' => t('Active'),
        'expired' => t('Expired'),
        'on_hold' => t('On Hold'),
      ]);

    return $fields;
  }
}
