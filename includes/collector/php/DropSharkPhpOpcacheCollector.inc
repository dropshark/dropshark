<?php

/**
 * Class DropSharkPhpOpcacheCollector.
 */
class DropSharkPhpOpcacheCollector extends DropSharkCollectorBase {

  protected $events = array('system');

  public function collect($event, $data = array()) {
    $data = array('type' => 'opcache');

    if (!$this->respond($event)) {
      return DropSharkCollector::RESPONSE_NONE;
    }

    if (!function_exists('opcache_get_status')) {
      $data['code'] = 'no_opcache';
      dropshark_queue_data($data);
      return DropSharkCollector::RESPONSE_COMPLETE;
    }

    $data += opcache_get_status(FALSE);
    $data['server'] = $this->getServer();
    $data['code'] = 0;

    dropshark_queue_data($data);
    return DropSharkCollector::RESPONSE_COMPLETE;
  }

}
