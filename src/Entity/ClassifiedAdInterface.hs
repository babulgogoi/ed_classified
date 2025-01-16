namespace Drupal\ed_classified\Entity;

/**
 * Provides an interface for the Classified Ad entity.
 */
interface ClassifiedAdInterface {

  public function getExpirationDate();

  public function setExpirationDate($date);

  public function getPaymentStatus();

  public function setPaymentStatus($status);

  public function getAdStatus();

  public function setAdStatus($status);
}
