<?php

class DropSharkLoadCollector extends DropSharkLinfoCollector {

  protected $events = array('system');
  protected $type = 'load';

  /**
   * {@inheritdoc}
   */
  public function collect($event, $data = array()) {

    if (!$this->respond($event)) {
      return DropSharkCollector::RESPONSE_NONE;
    }

    $data = $this->defaultResult();

    if (!$this->checkLinfo($data)) {
      return DropSharkCollector::RESPONSE_COMPLETE;
    }

    if (!$load = $this->parser->getLoad()) {
      $data['code'] = 'unable_to_determine_load';
      dropshark_queue_data($data);
      return DropSharkCollector::RESPONSE_COMPLETE;
    }

    $data = array_merge($data, $load);

    $data['code'] = 0;

    dropshark_queue_data($data);
    return DropSharkCollector::RESPONSE_COMPLETE;
  }

}
