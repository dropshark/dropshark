<?php

namespace Drupal\dropshark\Util;

use Drupal\Core\Config\ImmutableConfig;

/**
 * Class ConfigAwareTrait.
 */
trait ConfigAwareTrait {

  /**
   * Configuration object.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Sets configuration object onto the class.
   *
   * @param \Drupal\Core\Config\ImmutableConfig $config
   *   DropShark settings.
   *
   * @return $this
   */
  public function setConfig(ImmutableConfig $config) {
    $this->config = $config;
    return $this;
  }

}
