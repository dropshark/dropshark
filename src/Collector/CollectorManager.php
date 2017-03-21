<?php

namespace Drupal\dropshark\Collector;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\dropshark\Fingerprint\FingerprintInterface;
use Drupal\dropshark\Queue\QueueInterface;

class CollectorManager extends DefaultPluginManager implements CollectorManagerInterface {

  /**
   * Constructs a DropSharkCollectorManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations,
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\dropshark\Queue\QueueInterface $queue
   *   DropShark queue handler service.
   * @param \Drupal\dropshark\Fingerprint\FingerprintInterface $fingerprint
   *   DropShark fingerprint service.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, QueueInterface $queue, FingerprintInterface $fingerprint) {
    parent::__construct(
      'Plugin/DropShark/Collector',
      $namespaces,
      $module_handler,
      'Drupal\dropshark\Collector\CollectorInterface',
      'Drupal\dropshark\Collector\Annotation\DropSharkCollector'
    );
    $this->alterInfo('dropshark_collector_info');
    $this->setCacheBackend($cache_backend, 'dropshark_collectors');
    $this->factory = new CollectorFactory($this->getDiscovery(), CollectorInterface::class);
    $this->factory->setFingerprint($fingerprint)
      ->setModuleHandler($module_handler)
      ->setQueue($queue);
  }

  /**
   * {@inheritdoc}
   */
  public function collect(array $events, $data = array()) {
    foreach ($this->getDefinitions() as $pluginId => $definition) {
      /** @var \Drupal\dropshark\Collector\Annotation\DropSharkCollector $definition */
      if (in_array('all', $events) || array_intersect($events, $definition->events)) {
        /** @var \Drupal\dropshark\Collector\CollectorInterface $plugin */
        $plugin = $this->createInstance($pluginId);
        $plugin->collect($data);
      }
    }

  }

}
