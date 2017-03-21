<?php

namespace Drupal\dropshark\Queue;

/**
 * Interface QueueAwareInterface.
 */
interface QueueAwareInterface {

  /**
   * Sets the queue handler service.
   *
   * @param \Drupal\dropshark\Queue\QueueInterface $queue
   *   The queue handler service.
   *
   * @return $this
   */
  public function setQueue(QueueInterface $queue);

}
