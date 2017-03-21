<?php

namespace Drupal\dropshark\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Constructs the settings form.
   *
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   The Guzzle HTTP client.
   */
  public function __construct(ClientInterface $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('dropshark.settings');

    if ($config->get('site_token')) {
      $form = $this->statusForm($form);
    }
    else {
      $form = $this->registrationForm($form);
    }

    $form['#theme'] = 'system_config_form';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return array('dropshark.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dropshark_admin_config';
  }

  /**
   * Build the registration form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   *
   * @return array
   *   The form structure.
   */
  protected function registrationForm(array $form) {
    $config = $this->config('dropshark.settings');

    $form['instructions']['#markup'] = $this->t('In order to register your site with the DropShark service, you\'ll need to enter your credentials and site identifier.');
    $form['instructions']['#prefix'] = '<p>';
    $form['instructions']['#suffix'] = '</p>';

    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#description' => $this->t('Enter the email address which you\'ve registered for DropShark.'),
      '#required' => TRUE,
    );

    $form['password'] = array(
      '#type' => 'password',
      '#title' => $this->t('DropShark password'),
      '#description' => $this->t('Enter your DropShark password.'),
      '#required' => TRUE,
    );

    $form['site_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Site ID'),
      '#description' => $this->t('Find your site identifier on your DropShark dashboard.'),
      '#default_value' => $config->get('site_id'),
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#value' => $this->t('Register site'),
      '#type' => 'submit',
      '#element_validate' => array(
        array($this, 'registrationFormValidate')
      ),
      '#submit' => array(
        array($this, 'registrationFormSubmit')
      ),
    );

    return $form;
  }

  /**
   * Validation for registration form.
   */
  public function registrationFormValidate(&$element, FormStateInterface $form_state) {
    $config = $this->config('dropshark.settings');
    $config->set('host', 'http://local.data.dropshark.io');
    $config->save();

    try {
      $params['form_params']['user'] = $form_state->getValue('email');
      $params['form_params']['password'] = $form_state->getValue('password');
      $response = $this->httpClient->request('post', $config->get('host') . '/sites/token', $params);
      $result = json_decode((string) $response->getBody());
    }
    catch (\Exception $e) {
      $result = new \stdClass();
    }

    if (!empty($result->token)) {
      drupal_set_message($this->t('Your site has been registered with DropShark.'));
      $form_state->set('site_token', $result->token);
      $form_state->set('site_id', $form_state->getValue('site_id'));
    }
    else {
      $message = $this->t('Unable to register your site, please check your information and try again. If you continue to experience issues, please contact DropShark support.');
      $form_state->setErrorByName('', $message);
    }
  }

  /**
   * Submit handler for registration form.
   */
  public function registrationFormSubmit(array &$form, FormStateInterface $form_state) {
    $config = $this->config('dropshark.settings');
    $config->set('site_token', $form_state->get('site_token'));
    $config->set('site_id', $form_state->get('site_id'));
    $config->save();
  }

  /**
   * Build the status form.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   *
   * @return array
   *   The form structure.
   */
  protected function statusForm(array $form) {
    $config = $this->config('dropshark.settings');

    $params['@link'] = Link::fromTextAndUrl('DropShark', Url::fromUri('http://app.dropshark.io'))->toString();
    $form['instructions']['#markup'] = $this->t('Your site is registered and will send data to DropShark. Log in to @link to analyze your data.', $params);
    $form['instructions']['#prefix'] = '<p>';
    $form['instructions']['#suffix'] = '</p>';

    $form['status'] = array(
      '#type' => 'item',
      '#title' => $this->t('Site ID'),
      '#plain_text' => $config->get('site_id'),
    );

    $form['check'] = array(
      '#title' => t('Check connection'),
      '#type' => 'fieldset',
    );
    $form['check']['instructions']['#markup'] = t('Verify that your site is able to submit data to DropShark.');
    $form['check']['instructions']['#prefix'] = '<p>';
    $form['check']['instructions']['#suffix'] = '</p>';
    $form['check']['submit'] = array(
      '#value' => $this->t('Check'),
      '#type' => 'submit',
      '#submit' => array(
        array($this, 'statusFormCheckSubmit'),
      ),
    );

    $form['reset'] = array(
      '#title' => t('Reset token'),
      '#type' => 'fieldset',
    );
    $form['reset']['instructions']['#markup'] = t('If you\'re having trouble connecting to DropShark, try resetting the token then re-registering the site.');
    $form['reset']['instructions']['#prefix'] = '<p>';
    $form['reset']['instructions']['#suffix'] = '</p>';
    $form['reset']['submit'] = array(
      '#value' => $this->t('Reset'),
      '#type' => 'submit',
      '#submit' => array(
        array($this, 'statusFormResetSubmit'),
      ),
    );

    $form['collect'] = array(
      '#title' => t('Collect'),
      '#type' => 'fieldset',
    );
    $form['collect']['instructions'][0]['#markup'] = t('DropShark will attempt to submit your data during Drupal\'s cron. You may also want to set up a dedicated cron task dedicated to collecting DropShark data.');
    $form['collect']['instructions'][0]['#prefix'] = '<p>';
    $form['collect']['instructions'][0]['#suffix'] = '</p>';
    $form['collect']['instructions'][1]['#markup'] = t('Use this function to perform a real time collection of data from your site.');
    $form['collect']['instructions'][1]['#prefix'] = '<p>';
    $form['collect']['instructions'][1]['#suffix'] = '</p>';
    $form['collect']['submit'] = array(
      '#value' => $this->t('Collect'),
      '#type' => 'submit',
      '#submit' => array(
        array($this, 'statusFormCollectSubmit')
      ),
    );

    return $form;
  }

  /**
   * Checks connectivity to DropShark backend.
   */
  public function statusFormCheckSubmit() {

  }

  /**
   * Resets the site token.
   */
  public function statusFormResetSubmit() {
    $config = $this->config('dropshark.settings');
    $config->set('site_token', NULL);
    $config->save();
  }

  /**
   * Performs an on-demand collection of site data.
   */
  public function statusFormCollectSubmit() {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // No op.
  }

}
