<?php

namespace Drupal\dropshark\Util;

use Drupal\Core\Config\ImmutableConfig;

/**
 * Interface ConfigAwareInterface.
 */
interface ConfigAwareInterface {

  /**
   * Sets configuration object onto the class.
   *
   * @param \Drupal\Core\Config\ImmutableConfig $config
   *   DropShark settings.
   *
   * @return $this
   */
  public function setConfig(ImmutableConfig $config);

}
