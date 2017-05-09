<?php

namespace Drupal\dropshark\Collector;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\dropshark\Queue\QueueAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CollectorManager.
 */
class CollectorManager extends DefaultPluginManager implements CollectorManagerInterface {

  use QueueAwareTrait;

  /**
   * Constructs a DropSharkCollectorManager object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   */
  public function __construct(ContainerInterface $container) {
    /** @var \Traversable $namespaces */
    $namespaces = $container->get('container.namespaces');

    /** @var \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler */
    $moduleHandler = $container->get('module_handler');

    /** @var \Drupal\Core\Cache\CacheBackendInterface $cacheBackend */
    $cacheBackend = $container->get('cache.discovery');

    /** @var \Drupal\dropshark\Fingerprint\FingerprintInterface $fingerprint */
    $fingerprint = $container->get('dropshark.fingerprint');

    /** @var \Drupal\dropshark\Queue\QueueInterface $queue */
    $queue = $container->get('dropshark.queue');

    /** @var \Drupal\dropshark\Util\LinfoFactory $linfoFactory */
    $linfoFactory = $container->get('dropshark.linfo_factory');

    /** @var \Drupal\Core\Config\ConfigFactoryInterface $configFactory */
    $configFactory = $container->get('config.factory');

    /** @var \Drupal\Core\State\StateInterface $state */
    $state = $container->get('state');

    parent::__construct(
      'Plugin/DropShark/Collector',
      $namespaces,
      $moduleHandler,
      'Drupal\dropshark\Collector\CollectorInterface',
      'Drupal\dropshark\Collector\Annotation\DropSharkCollector'
    );
    $this->alterInfo('dropshark_collector_info');
    $this->setCacheBackend($cacheBackend, 'dropshark_collectors');
    $this->factory = new CollectorFactory($this->getDiscovery(), CollectorInterface::class);

    $this->factory->setConfig($configFactory->get('dropshark.settings'))
      ->setFingerprint($fingerprint)
      ->setModuleHandler($moduleHandler)
      ->setQueue($queue)
      ->setState($state);

    if ($linfo = $linfoFactory->createInstance()) {
      $this->factory->setLinfo($linfo);
    }

    $this->queue = $queue;
  }

  /**
   * {@inheritdoc}
   */
  public function collect(array $events, array $data = [], $immediate = FALSE) {
    foreach ($this->getDefinitions() as $pluginId => $definition) {
      /** @var \Drupal\dropshark\Collector\Annotation\DropSharkCollector $definition */
      if (in_array('all', $events) || array_intersect($events, $definition->events)) {
        /** @var \Drupal\dropshark\Collector\CollectorInterface $plugin */
        $plugin = $this->createInstance($pluginId);
        $plugin->collect($data);
      }
    }

    if ($immediate) {
      $this->queue->setImmediateTransmit();
    }
  }

}
