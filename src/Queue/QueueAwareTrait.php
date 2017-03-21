<?php

namespace Drupal\dropshark\Queue;

/**
 * Class QueueAwareTrait.
 */
trait QueueAwareTrait {

  /**
   * DropShark queue handling service.
   *
   * @var \Drupal\dropshark\Queue\QueueInterface
   */
  protected $queue;

  /**
   * Sets the queue handler service.
   *
   * @param \Drupal\dropshark\Queue\QueueInterface $queue
   *   The queue handler service.
   *
   * @return $this
   */
  public function setQueue(QueueInterface $queue) {
    $this->queue = $queue;
    return $this;
  }

}
