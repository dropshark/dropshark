<?php

namespace Drupal\dropshark\Util;

use Drupal\Core\State\StateInterface;

/**
 * Trait StateAwareTrait.
 */
trait StateAwareTrait {

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Sets the state service.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   *
   * @return $this
   */
  public function setState(StateInterface $state) {
    $this->state = $state;
    return $this;
  }

}
