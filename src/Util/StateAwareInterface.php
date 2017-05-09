<?php

namespace Drupal\dropshark\Util;

use Drupal\Core\State\StateInterface;

/**
 * Interface StateAwareInterface.
 */
interface StateAwareInterface {

  /**
   * Sets the state service.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   *
   * @return $this
   */
  public function setState(StateInterface $state);

}
