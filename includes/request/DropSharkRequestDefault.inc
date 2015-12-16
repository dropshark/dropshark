<?php

/**
 * Class DropSharkRequestDefault.
 */
class DropSharkRequestDefault implements DropSharkRequest {

  /**
   * {@inheritdoc}
   */
  public function getHost() {
    return DROPSHARK_HOST;
  }

  /**
   * {@inheritdoc}
   */
  public function post($endpoint, $data) {
    $url = $this->getHost() . '/' . $endpoint;
    $options['method'] = 'POST';
    $options['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
    $options['data'] = drupal_http_build_query($data);
    $result = drupal_http_request($url, $options);
    $result->data = json_decode($result->data);
    return $result;
  }

}
