namespace Drupal\ed_classified\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\Entity\Node;

/**
 * Processes expired classified ads.
 *
 * @QueueWorker(
 *   id = "classified_ad_expiration_worker",
 *   title = @Translation("Classified Ad Expiration Worker"),
 *   cron = {"time" = 60}
 * )
 */
class ClassifiedAdExpirationWorker extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $ad_id = $data['ad_id'];
    $node = Node::load($ad_id);
    if ($node && $node->getType() == 'classified_ad') {
      $node->set('status', 0); // Unpublish the ad.
      $node->set('field_ad_status', 'Expired');
      $node->save();
    }
  }
}
