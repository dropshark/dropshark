<?php

namespace Drupal\dropshark\Collector;

/**
 * Interface CollectorManagerInterface.
 */
interface CollectorManagerInterface {

  /**
   * Collect data.
   *
   * @param array $events
   *   A value indicating an event or type of an event to which the collector
   *   may respond.
   * @param array $data
   *   Optional data necessary for the collector to perform its collection. This
   *   is likely information to indicate which server on which a collection is
   *   being ran, or to indicate which instance of a collection is being ran.
   */
  public function collect(array $events, $data = array());

}
