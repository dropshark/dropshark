<?php

namespace Drupal\dropshark\Collector;

use Drupal\Component\Plugin\Factory\DefaultFactory;
use Drupal\dropshark\Fingerprint\FingerprintAwareTrait;
use Drupal\dropshark\Queue\QueueAwareTrait;
use Drupal\dropshark\Util\ModuleHandlerAwareInterface;
use Drupal\dropshark\Util\ModuleHandlerAwareTrait;

/**
 * Class CollectorFactory.
 *
 * Instantiates collector plugins.
 */
class CollectorFactory extends DefaultFactory {

  use FingerprintAwareTrait;
  use ModuleHandlerAwareTrait;
  use QueueAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function createInstance($plugin_id, array $configuration = array()) {
    /** @var \Drupal\dropshark\Collector\CollectorInterface $plugin */
    $plugin = parent::createInstance($plugin_id, $configuration);
    $plugin->setFingerprint($this->fingerprint)->setQueue($this->queue);

    if ($plugin instanceof ModuleHandlerAwareInterface) {
      $plugin->setModuleHandler($this->moduleHandler);
    }

    return $plugin;
  }

}
