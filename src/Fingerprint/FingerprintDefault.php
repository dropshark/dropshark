<?php

namespace Drupal\dropshark\Fingerprint;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DrupalKernelInterface;

/**
 * Class FingerprintDefault.
 */
class FingerprintDefault implements FingerprintInterface {

  /**
   * The kernel.
   *
   * @var \Drupal\Core\DrupalKernelInterface
   */
  protected $kernel;

  /**
   * The site ID.
   *
   * @var string
   */
  protected $siteId;

  /**
   * Constructs the settings form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The factory for configuration objects.
   * @param \Drupal\Core\DrupalKernelInterface $kernel
   *   The kernel.
   */
  public function __construct(ConfigFactoryInterface $configFactory, DrupalKernelInterface $kernel) {
    $config = $configFactory->get('dropshark.settings');
    $this->siteId = $config->get('site_id');
    $this->kernel = $kernel;
  }

  /**
   * {@inheritdoc}
   */
  public function getFingerprint() {
    //$dir = $_SERVER['HOME'] . '/.dropshark/fingerprints';
    $dir = $_SERVER['HOME'] . '/ds/fingerprints';
    $file = $dir . '/' . $this->siteId;

    if (!is_file($file)) {
      if (!is_dir($dir)) {
        @mkdir($dir, 0755, TRUE);
      }

      $fingerprint['host'] = $_SERVER['HTTP_HOST'];
      $fingerprint['app_root'] = $this->kernel->getAppRoot();
      $fingerprint['site_path'] = $this->kernel->getSitePath();
      $timestamp = explode(' ', microtime());
      $fingerprint['timestamp'] = $timestamp[1] . $timestamp[0];
      $fingerprint = base64_encode(json_encode($timestamp));
      file_put_contents($file, $fingerprint);
    }
    else {
      $fingerprint = file_get_contents($file);
    }

    dsm($fingerprint, $file);
    return $fingerprint;
  }

}
