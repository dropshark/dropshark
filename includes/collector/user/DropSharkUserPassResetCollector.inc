<?php

/**
 * Class DropSharkUserPassResetCollector.
 */
class DropSharkUserPassResetCollector extends DropSharkCollectorBase {
  protected $events = array('user_pass_reset');
  protected $type = 'user_pass_reset';

  /**
   * {@inheritdoc}
   */
  public function collect($event, $account = array()) {
    if (!$this->respond($event)) {
      return DropSharkCollector::RESPONSE_NONE;
    }

    $data = $this->defaultResult();
    $data['account'] = $account;
    $data['code'] = 0;
    $data['log'] = TRUE;
    dropshark_queue_data($data);

    return DropSharkCollector::RESPONSE_COMPLETE;
  }

}
