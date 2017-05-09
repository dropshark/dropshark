<?php

namespace Drupal\dropshark\Collector;

use Drupal\dropshark\Fingerprint\FingerprintAwareInterface;
use Drupal\dropshark\Queue\QueueAwareInterface;
use Drupal\dropshark\Util\ConfigAwareInterface;
use Drupal\dropshark\Util\StateAwareInterface;

/**
 * Interface CollectorInterface.
 */
interface CollectorInterface extends ConfigAwareInterface, FingerprintAwareInterface, QueueAwareInterface, StateAwareInterface {

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
  public function collect(array $data = []);

  /**
   * Perform checks which were deferred until the end of the request.
   */
  public function finalize();

}
