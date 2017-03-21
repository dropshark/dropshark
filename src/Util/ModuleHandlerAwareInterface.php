<?php

namespace Drupal\dropshark\Util;

use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Interface ModuleHandlerAwareInterface.
 */
interface ModuleHandlerAwareInterface {

  /**
   * Set the module handler.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler service.
   *
   * @return $this
   */
  public function setModuleHandler(ModuleHandlerInterface $moduleHandler);

}
