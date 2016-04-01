<?php

/**
 * Class DropSharkNodeCollector.
 */
class DropSharkNodeCollector extends DropSharkCollectorBase {
  protected $events = array('node_insert', 'node_update', 'node_delete');
  protected $type = 'node_';

  /**
   * {@inheritdoc}
   */
  public function collect($event, $node = array()) {
    if (!$this->respond($event)) {
      return DropSharkCollector::RESPONSE_NONE;
    }

    $data = $this->defaultResult($event);
    $data['node'] = $node;
    $data['code'] = 0;
    $data['log'] = TRUE;
    dropshark_queue_data($data);

    return DropSharkCollector::RESPONSE_DEFERRED;
  }

  /**
   * {@inheritdoc}
   */
  public function finalize() {
    $this->byStatus();
  }

  /**
   * Collect counts of content by status.
   */
  protected function byStatus() {
    $data = $this->defaultResult('node_status');
    $query = "SELECT COUNT(*) AS c, n.status FROM {node} AS n GROUP BY status";
    $data['node_status'] = db_query($query, array(1))->fetchAllKeyed(1, 0);
    $data['code'] = 0;
    dropshark_queue_data($data);
  }

}
