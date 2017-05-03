<?php

namespace Drupal\dropshark\Util;

use Linfo\Linfo;

/**
 * Interface LinfoAwareInterface.
 */
interface LinfoAwareInterface {

  /**
   * Set the Linfo instance.
   *
   * @param \Linfo\Linfo $linfo
   *   The Linfo instance.
   *
   * @return $this
   */
  public function setLinfo(Linfo $linfo);

}
