<?php

namespace Drupal\dropshark\Collector;

use Drupal\dropshark\Fingerprint\FingerprintAwareInterface;
use Drupal\dropshark\Queue\QueueAwareInterface;

/**
 * Interface CollectorInterface.
 */
interface CollectorInterface extends FingerprintAwareInterface, QueueAwareInterface {

  /**
   * Indicates a successful collection of data.
   *
   * Non-zero values indicate that the collection failed.
   */
  const STATUS_SUCCESS = 0;

  /**
   * Collect data.
   *
   * @param array $data
   *   Optional, data utilized by the collector.
   */
  public function collect($data = array());

}
