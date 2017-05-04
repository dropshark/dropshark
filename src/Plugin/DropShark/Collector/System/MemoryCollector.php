<?php

namespace Drupal\dropshark\Plugin\DropShark\Collector\System;

use Drupal\dropshark\Collector\CollectorInterface;

/**
 * Class MemoryCollector.
 *
 * @DropSharkCollector(
 *   id = "memory",
 *   title = @Translation("Memory"),
 *   description = @Translation("Memory usage information."),
 *   events = {"system"}
 * )
 */
class MemoryCollector extends LinfoCollector {

  /**
   * {@inheritdoc}
   */
  public function collect($data = array()) {
    $data = $this->defaultResult();

    if (!$this->checkLinfo($data)) {
      return;
    }

    $memory = $this->getData();

    if (empty($memory)) {
      $data['code'] = 'unable_to_determine_memory';
      $this->queue->add($data);
      return;
    }

    $data['code'] = CollectorInterface::STATUS_SUCCESS;
    $data['free'] = $memory['free'];
    $data['total'] = $memory['total'];
    $data['used_percent'] = 1 - $memory['free'] / $memory['total'];
    $this->queue->add($data);
  }

  /**
   * Get memory usage information from the OS.
   *
   * @return array
   *   Memory usage information, keyed by type ("Mem:", "Swap:").
   */
  protected function getData() {
    static $data = NULL;
    if ($data === NULL) {
      $data = $this->parser->getRam();
    }
    return $data;
  }

}
