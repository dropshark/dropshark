<?php

namespace Drupal\dropshark\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CollectionController.
 */
class CollectionController extends ControllerBase {

  /**
   * Performs data collection.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response.
   */
  public function collect(Request $request) {
    $response = new JsonResponse();

    $config = $this->config('dropshark.settings');

    $site_id = $config->get('site_id');
    $token = $config->get('site_id');

    if (!$site_id || !$token) {
      $response->setStatusCode(404);
      $response->setData([
        'error' => 'DropShark not configured',
        'timestamp' => date('c'),
      ]);
      return $response;
    }

    if ($site_id != $request->query->get('key')) {
      $response->setStatusCode(404);
      $response->setData([
        'error' => 'invalid key',
        'timestamp' => date('c'),
      ]);
      return $response;
    }

    // Do some collecting.
    $response->setData([
      'code' => 200,
      'result' => 'Data collection complete.',
      'timestamp' => date('c'),
    ]);

    return $response;
  }

}
