<?php

namespace Drupal\dropshark_testing;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\dropshark\Request\RequestInterface;

/**
 * Class Request.
 */
class TestRequest implements RequestInterface {

  /**
   * DropShark configuration.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Request constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Configuration factory.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->config = $configFactory->get('dropshark.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function checkToken() {
    $result = new \stdClass();

    if ($this->config->get('site_token') == 'valid_token') {
      $data = new \stdClass();
      $data->site_id = '0bb250ce-ffd5-4563-81fa-c8a165cd6af8';
      $result->data = $data;
    }
    else {
      $result->code = 400;
      $result->error = 'Bad Request';
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getToken($email, $password, $siteId) {
    $result = new \stdClass();

    if ($email == 'test@user.com' && $password == 'password' && $siteId == '0bb250ce-ffd5-4563-81fa-c8a165cd6af8') {
      $result->code = 200;
      $data = new \stdClass();
      $data->token = 'valid_token';
      $result->data = $data;
    }
    else {
      $result->code = 403;
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function postData(array $data) {
    // TODO: Implement postData() method.
  }

}
