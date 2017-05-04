<?php

namespace Drupal\dropshark\Plugin\DropShark\Collector\System;

use Drupal\dropshark\Collector\CollectorInterface;

/**
 * Class LoadCollector.
 *
 * @DropSharkCollector(
 *   id = "load",
 *   title = @Translation("CPU Load"),
 *   description = @Translation("CPU Load information."),
 *   events = {"system"}
 * )
 */
class LoadCollector extends LinfoCollector {

  /**
   * {@inheritdoc}
   */
  public function collect($data = array()) {
    $data = $this->defaultResult();

    if (!$this->checkLinfo($data)) {
      return;
    }

    if (!$load = $this->parser->getLoad()) {
      $data['code'] = 'unable_to_determine_load';
      $this->queue->add($data);
      return;
    }

    $data = array_merge($data, $load);
    $data['code'] = CollectorInterface::STATUS_SUCCESS;
    $this->queue->add($data);
  }

}
