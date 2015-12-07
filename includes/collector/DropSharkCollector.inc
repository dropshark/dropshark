<?php

/**
 * Interface DropSharkCollector.
 */
interface DropSharkCollector {

  /**
   * DropSharkCollector constructor.
   *
   * @param array $definition
   *   Collector definition obtained from hook_dropshark_collector_info().
   */
  public function __construct($definition);

  /**
   * Collect data.
   *
   * @param array $context
   *   Data necessary for the collector to perform its collection. This is
   *   likely information to indicate which server on which a collection is
   *   being ran, or to indicate which instance of a collection is being ran.
   *
   * @return array
   *   Data obtained by the collector. Should always contain a "code" element
   *   which represents whether the collection ran successfully, an exit code.
   *   Additional elements such as "free", "used", "used_percent" are common but
   *   are specific to each collector.
   */
  public function collect($context = array());

}
