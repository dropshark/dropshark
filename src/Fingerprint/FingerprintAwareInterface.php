<?php

namespace Drupal\dropshark\Fingerprint;

/**
 * Interface FingerprintAwareInterface.
 */
interface FingerprintAwareInterface {

  /**
   * Set the fingerprint service.
   *
   * @param \Drupal\dropshark\Fingerprint\FingerprintInterface $fingerprint
   *   The fingerprint service.
   *
   * @return $this
   */
  public function setFingerprint(FingerprintInterface $fingerprint);

}
