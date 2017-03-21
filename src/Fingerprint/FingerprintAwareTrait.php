<?php

namespace Drupal\dropshark\Fingerprint;

/**
 * Trait FingerprintAwareTrait.
 */
trait FingerprintAwareTrait {

  /**
   * The fingerprint service.
   *
   * @var \Drupal\dropshark\Fingerprint\FingerprintInterface
   */
  protected $fingerprint;

  /**
   * Set the fingerprint service.
   *
   * @param \Drupal\dropshark\Fingerprint\FingerprintInterface $fingerprint
   *   The fingerprint service.
   *
   * @return $this
   */
  public function setFingerprint(FingerprintInterface $fingerprint) {
    $this->fingerprint = $fingerprint;
    return $this;
  }

}
