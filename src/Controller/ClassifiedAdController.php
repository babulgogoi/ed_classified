namespace Drupal\ed_classified\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Ed Classified routes.
 */
class ClassifiedAdController extends ControllerBase {
  public function view($nid) {
    $node = \Drupal\node\Entity\Node::load($nid);
    return [
      '#theme' => 'node--classified-ad',
      '#node' => $node,
    ];
  }
}
