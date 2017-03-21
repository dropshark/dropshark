<?php

namespace Drupal\dropshark\Queue;

use Drupal\dropshark\Collector\CollectorInterface;

/**
 * Class DbQueue.
 */
class DbQueue implements QueueInterface {

  /**
   * {@inheritdoc}
   */
  public function add(array $data) {
    // TODO: Implement add() method.
  }

  /**
   * {@inheritdoc}
   */
  public function hasDeferred() {
    // TODO: Implement hasDeferred() method.
  }

  /**
   * {@inheritdoc}
   */
  public function needsImmediateTransmit() {
    // TODO: Implement needsImmediateTransmit() method.
  }

  /**
   * {@inheritdoc}
   */
  public function persist() {
    // TODO: Implement persist() method.
  }

  /**
   * {@inheritdoc}
   */
  public function processDeferred() {
    // TODO: Implement processDeferred() method.
  }

  /**
   * {@inheritdoc}
   */
  public function setDeferred(CollectorInterface $collector) {
    // TODO: Implement setDeferred() method.
  }

  /**
   * {@inheritdoc}
   */
  public function setImmediateTransmit() {
    // TODO: Implement setImmediateTransmit() method.
  }

  /**
   * {@inheritdoc}
   */
  public function transmit() {
    // TODO: Implement transmit() method.
  }

}
