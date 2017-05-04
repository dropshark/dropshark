<?php

namespace Drupal\dropshark\Plugin\DropShark\Collector\PHP;

use Drupal\dropshark\Collector\CollectorBase;
use Drupal\dropshark\Collector\CollectorInterface;

/**
 * Class ApcCollector.
 *
 * @DropSharkCollector(
 *   id = "apc",
 *   title = @Translation("APC"),
 *   description = @Translation("APC utilization information."),
 *   events = {"system"}
 * )
 */
class ApcCollector extends CollectorBase {

  /**
   * {@inheritdoc}
   */
  public function collect($data = array()) {
    $data = $this->defaultResult();
    if (!function_exists('apc_cache_info')) {
      $data['code'] = 'no_apc';
      $this->queue->add($data);
      return;
    }
    if (!$info = @apc_cache_info('', TRUE)) {
      $data['code'] = 'apc_not_enabled';
      $this->queue->add($data);
      return;
    }
    $data += $info;
    $data['sma'] = apc_sma_info(TRUE);
    $data['code'] = CollectorInterface::STATUS_SUCCESS;
    $this->queue->add($data);
  }

}