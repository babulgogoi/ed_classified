namespace Drupal\ed_classified\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ClassifiedAdForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'classified_ad_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Ad Title'),
      '#description' => $this->t('Enter a descriptive title for your classified ad.'),
      '#maxlength' => 255,
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Ad Description'),
      '#description' => $this->t('Provide details about the item or service.'),
      '#required' => TRUE,
    ];

    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#options' => [
        'electronics' => $this->t('Electronics'),
        'furniture' => $this->t('Furniture'),
        'vehicles' => $this->t('Vehicles'),
        'real_estate' => $this->t('Real Estate'),
        'services' => $this->t('Services'),
      ],
      '#empty_option' => $this->t('- Select a category -'),
      '#required' => TRUE,
    ];

    $form['ad_status'] = [
      '#type' => 'radios',
      '#title' => $this->t('Ad Status'),
      '#options' => [
        'active' => $this->t('Active'),
        'inactive' => $this->t('Inactive'),
      ],
      '#required' => TRUE,
    ];

    $form['images'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload Images'),
      '#description' => $this->t('Upload images related to your ad.'),
      '#upload_location' => 'public://classified_ads/',
      '#multiple' => TRUE,
      '#required' => FALSE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Post Ad'),
      '#attributes' => ['class' => ['button--primary']],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    $description = $form_state->getValue('description');
    $category = $form_state->getValue('category');
    $status = $form_state->getValue('ad_status');
    $images = $form_state->getValue('images');

    // Create a new classified ad node.
    $node = \Drupal\node\Entity\Node::create([
      'type' => 'classified_ad',
      'title' => $title,
      'field_ad_status' => $status,
      'field_category' => $category,
      'field_description' => $description,
      'field_images' => $images,
    ]);
    $node->save();

    $this->messenger()->addMessage($this->t('Your classified ad "%title" has been posted.', ['%title' => $title]));
  }
}
