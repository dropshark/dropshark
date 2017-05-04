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
   * The Linfo parser object.
   *
   * @var mixed
   */
  protected $parser;

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
    $this->parser = $linfo->getParser();
    return $this;
  }

}
