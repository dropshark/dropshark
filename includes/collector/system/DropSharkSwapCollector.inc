<?php

/**
 * Class DropSharkSwapCollector.
 */
class DropSharkSwapCollector extends DropSharkMemoryCollector {

  protected $events = array('system');

  /**
   * {@inheritdoc}
   */
  public function collect($event, $data = array()) {

    if (!$this->respond($event)) {
      return DropSharkCollector::RESPONSE_NONE;
    }

    $data = array('type' => 'swap');
    $data['server'] = $this->getServer();

    $memory = $this->getData();

    if (empty($memory['Swap:'])) {
      $data['code'] = 'unable_to_determine_swap';
      dropshark_queue_data($data);
      return DropSharkCollector::RESPONSE_COMPLETE;
    }

    $memory = $memory['Swap:'];

    if (empty($memory['total'])) {
      $data['code'] = 'unable_to_determine_swap_total';
      dropshark_queue_data($data);
      return DropSharkCollector::RESPONSE_COMPLETE;
    }

    $data['code'] = 0;
    $data['free'] = $memory['free'];
    $data['used'] = $memory['used'];
    $data['total'] = $memory['total'];
    $data['used_percent'] = $memory['used'] / $memory['total'];

    dropshark_queue_data($data);
    return DropSharkCollector::RESPONSE_COMPLETE;
  }

}
