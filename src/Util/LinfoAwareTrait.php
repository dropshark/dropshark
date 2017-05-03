<?php

namespace Drupal\dropshark\Util;

use Linfo\Linfo;

/**
 * Trait LinfoAwareTrait.
 */
trait LinfoAwareTrait  {

  /**
   * The linfo instance.
   *
   * @var \Linfo\Linfo
   */
  protected $linfo;

  /**
   * Set the Linfo instance.
   *
   * @param \Linfo\Linfo $linfo
   *   The Linfo instance.
   *
   * @return $this
   */
  public function setLinfo(Linfo $linfo) {
    $this->linfo = $linfo;
    return $this;
  }

}
