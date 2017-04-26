<?php

namespace Drupal\dropshark\Request;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Class DropSharkRequest.
 */
class DropSharkRequest implements RequestInterface {

  /**
   * The URL to the DropShark backend.
   *
   * @var string
   */
  protected $host;

  /**
   * HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The site token.
   *
   * @var string
   */
  protected $token;

  /**
   * DropSharkRequest constructor.
   *
   * @param ConfigFactoryInterface $configFactory
   *   Configuration options.
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   HTTP client.
   */
  public function __construct(ConfigFactoryInterface $configFactory, ClientInterface $httpClient) {
    $config = $configFactory->get('dropshark.settings');
    $this->host = $config->get('host');
    $this->token = $config->get('site_token');
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public function checkToken() {
    $result = new \stdClass();

    $options = [];
    if ($this->token) {
      $options['headers']['Authorization'] = $this->token;
    }

    try {
      $response = $this->httpClient->request('get', $this->host . '/sites/token', $options);
      $result->code = $response->getStatusCode();
      $result->data = \GuzzleHttp\json_decode($response->getBody());
    }
    catch (ClientException $e) {
      if ($e->hasResponse()) {
        $result->code = $e->getResponse()->getStatusCode();
        $result->data = \GuzzleHttp\json_decode($e->getResponse()->getBody());
      }
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getToken($email, $password, $siteId) {
    $params = ['user' => $email, 'password' => $password, 'site_id' => $siteId];
    $options = $this->requestOptions($params);

    $result = new \stdClass();
    try {
      $response = $this->httpClient->request('post', $this->host . '/sites/token', $options);
      $result->code = $response->getStatusCode();
      $result->data = \GuzzleHttp\json_decode($response->getBody());
    }
    catch (ClientException $e) {
      if ($e->hasResponse()) {
        $result->code = $e->getResponse()->getStatusCode();
        $result->data = \GuzzleHttp\json_decode($e->getResponse()->getBody());
      }
    }

    return $result;
  }

  /**
   * Prepares an array of options for Guzzle requests.
   */
  protected function requestOptions($params, $siteId = NULL) {
    $options = [];

    if (!empty($params)) {
      $options['form_params'] = $params;
    }

    if ($this->token) {
      $options['headers']['Authorization'] = $this->token;
    }

    if ($siteId) {
      $options['headers']['X-DropShark-Site'] = $siteId;
    }

    return $options;
  }

}
