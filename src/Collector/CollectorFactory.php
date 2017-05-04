<?php

namespace Drupal\dropshark\Collector;

use Drupal\Component\Plugin\Factory\DefaultFactory;
use Drupal\dropshark\Fingerprint\FingerprintAwareTrait;
use Drupal\dropshark\Queue\QueueAwareTrait;
use Drupal\dropshark\Util\ConfigAwareInterface;
use Drupal\dropshark\Util\ConfigAwareTrait;
use Drupal\dropshark\Util\LinfoAwareInterface;
use Drupal\dropshark\Util\LinfoAwareTrait;
use Drupal\dropshark\Util\ModuleHandlerAwareInterface;
use Drupal\dropshark\Util\ModuleHandlerAwareTrait;

/**
 * Class CollectorFactory.
 *
 * Instantiates collector plugins.
 */
class CollectorFactory extends DefaultFactory implements ConfigAwareInterface {

  use ConfigAwareTrait;
  use FingerprintAwareTrait;
  use LinfoAwareTrait;
  use ModuleHandlerAwareTrait;
  use QueueAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function createInstance($plugin_id, array $configuration = array()) {
    /** @var \Drupal\dropshark\Collector\CollectorInterface $plugin */
    $plugin = parent::createInstance($plugin_id, $configuration);

    $plugin->setConfig($this->config)
      ->setFingerprint($this->fingerprint)
      ->setQueue($this->queue);

    if ($plugin instanceof LinfoAwareInterface) {
      $plugin->setLinfo($this->linfo);
    }

    if ($plugin instanceof ModuleHandlerAwareInterface) {
      $plugin->setModuleHandler($this->moduleHandler);
    }

    return $plugin;
  }

}
