<?php

namespace Drupal\dropshark\Plugin\DropShark\Collector\System;

use Drupal\dropshark\Collector\CollectorBase;
use Drupal\dropshark\Util\LinfoAwareInterface;
use Drupal\dropshark\Util\LinfoAwareTrait;

/**
 * Class LinfoCollector.
 *
 * Base class for collectors which utilize the Linfo library for collecting
 * server stats.
 */
abstract class LinfoCollector extends CollectorBase implements LinfoAwareInterface {

  use LinfoAwareTrait;

  /**
   * Check for Linfo library report error if not available.
   *
   * @para array $data
   *   Collector result array.
   *
   * @return bool
   *   Indicates whether or not Linfo is available.
   */
  protected function checkLinfo($data) {
    if (!$this->hasLinfo()) {
      $data['code'] = 'linfo_library_not_available';
      $this->queue->add($data);
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Determines if the Linfo library is available.
   *
   * @return bool
   *   Indicates if the Linfo library is available.
   */
  protected function hasLinfo() {
    return $this->linfo && $this->parser;
  }

}
