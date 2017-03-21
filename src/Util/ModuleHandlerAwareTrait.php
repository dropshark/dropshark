<?php

namespace Drupal\dropshark\Util;

use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Trait ModuleHandlerAwareTrait.
 */
trait ModuleHandlerAwareTrait {

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Set the module handler.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler service.
   *
   * @return $this
   */
  public function setModuleHandler(ModuleHandlerInterface $moduleHandler) {
    $this->moduleHandler = $moduleHandler;
    return $this;
  }

}
