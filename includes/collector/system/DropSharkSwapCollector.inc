<?php

/**
 * Class DropSharkSwapCollector.
 */
class DropSharkSwapCollector extends DropSharkMemoryCollector {

  /**
   * {@inheritdoc}
   */
  public function collect($context = array()) {

    $data = array();

    $memory = $this->get_data();

    if (empty($memory['Swap:'])) {
      $data['code'] = 1;
      return $data;
    }

    $memory = $memory['Swap:'];

    if (empty($memory['total'])) {
      $data['code'] = 2;
      return $data;
    }

    $data['code'] = 0;
    $data['free'] = $memory['free'];
    $data['used'] = $memory['used'];
    $data['total'] = $memory['total'];
    $data['used_percent'] = $memory['used'] / $memory['total'];

    return $data;
  }

}
