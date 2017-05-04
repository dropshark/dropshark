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

    $key = $this->state()->get('system.cron_key');

    if ($key != $request->query->get('key')) {
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
