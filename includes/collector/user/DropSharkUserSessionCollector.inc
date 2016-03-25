<?php

/**
 * Class DropSharkUserSessionCollector.
 */
class DropSharkUserSessionCollector extends DropSharkCollectorBase {
  protected $events = array('user_login', 'user_logout');
  protected $type = 'user_sessions';

  /**
   * {@inheritdoc}
   */
  public function collect($event, $data = array()) {
    if (!$this->respond($event)) {
      return DropSharkCollector::RESPONSE_NONE;
    }

    return DropSharkCollector::RESPONSE_DEFERRED;
  }

  /**
   * {@inheritdoc}
   */
  public function finalize() {
    $data['code'] = 0;
    $data['count'] = $this->getCount();
    dropshark_queue_data($data);
  }

  /**
   * Compute the number of active user sessions.
   *
   * @TODO: investigate options to count sessions for alternate session storage.
   *
   * @see user_block_view()
   */
  protected function getCount() {
    $interval = REQUEST_TIME - variable_get('user_block_seconds_online', 900);

    // Perform database queries to gather online user lists. We use s.timestamp
    // rather than u.access because it is much faster.
    $authenticated_count = db_query("SELECT COUNT(DISTINCT s.uid) FROM {sessions} s WHERE s.timestamp >= :timestamp AND s.uid > 0", array(':timestamp' => $interval))->fetchField();
    return $authenticated_count;
  }
}
