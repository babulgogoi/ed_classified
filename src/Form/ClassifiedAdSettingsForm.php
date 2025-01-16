namespace Drupal\ed_classified\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure settings for the Classified Ads module.
 */
class ClassifiedAdSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['ed_classified.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'classified_ad_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ed_classified.settings');

    $form['expiration_period'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Expiration Period (in days)'),
      '#default_value' => $config->get('expiration_period'),
      '#description' => $this->t('Number of days after which the ad will expire.'),
    ];

    $form['hold_period'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hold Period (in days)'),
      '#default_value' => $config->get('hold_period'),
      '#description' => $this->t('Number of days the ad will remain on hold after expiration.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('ed_classified.settings')
      ->set('expiration_period', $form_state->getValue('expiration_period'))
      ->set('hold_period', $form_state->getValue('hold_period'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
