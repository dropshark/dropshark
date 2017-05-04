<?php

namespace Drupal\dropshark\Collector;

use Drupal\Core\Plugin\PluginBase;
use Drupal\dropshark\Fingerprint\FingerprintAwareTrait;
use Drupal\dropshark\Queue\QueueAwareTrait;
use Drupal\dropshark\Util\ConfigAwareTrait;

/**
 * Class CollectorBase.
 */
abstract class CollectorBase extends PluginBase implements CollectorInterface {

  use ConfigAwareTrait;
  use FingerprintAwareTrait;
  use QueueAwareTrait;

  /**
   * DropShark queue handler service.
   *
   * @var \Drupal\dropshark\Queue\QueueInterface
   */
  protected $queue;

  /**
   * A default value to be used for a collector's result.
   *
   * This contains the properties needed to report a valid result. Collectors
   * will add and overwrite properties as needed.
   *
   * Note: 'ds_timestamp' and 'ds_fingerprint' properties gets added when the
   * collected data is queued.
   *
   * @param string $type
   *   The type indicator of the data being collected.
   *
   * @return array
   *   Array of collected data.
   */
  protected function defaultResult($type = NULL) {
    $result = [];

    if (!$type) {
      $type = $this->getPluginId();
    }

    $result['site_id'] = $this->config->get('site_id');
    $result['type'] = $type;
    $result['server'] = $this->getServer();
    $result['ds_collector_id'] = "{$result['type']}|{$result['server']}";
    $result['code'] = 'unknown_error';
    $result['fingerprint'] = $this->fingerprint->getFingerprint();

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function finalize() {
    // No op.
  }

  /**
   * The server where the data is being collected.
   *
   * Metrics specific to a server should specify which server they're collected
   * from.
   *
   * @return string
   *   The server identifier.
   */
  protected function getServer() {
    // TODO: make this dynamic, configurable.
    return 'default';
  }

}
