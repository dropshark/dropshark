<?php

/**
 * Class DropSharkCollectorBase.
 */
abstract class DropSharkCollectorBase implements DropSharkCollector {

  protected $definition;

  /**
   * {@inheritdoc}
   */
  public function __construct($definition) {
    $this->definition = $definition;
  }

  /**
   * @return string
   */
  public function getServer() {
    // TODO: make this dynamic, configurable.
    return 'default';
  }

}
