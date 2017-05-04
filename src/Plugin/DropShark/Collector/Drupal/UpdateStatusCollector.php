<?php

namespace Drupal\dropshark\Plugin\DropShark\Collector\Drupal;

use Drupal\dropshark\Collector\CollectorBase;
use Drupal\dropshark\Collector\CollectorInterface;
use Drupal\dropshark\Util\ModuleHandlerAwareInterface;
use Drupal\dropshark\Util\ModuleHandlerAwareTrait;

/**
 * Class UpdateStatusCollector.
 *
 * @DropSharkCollector(
 *   id = "drupal_updates",
 *   title = @Translation("Drupal Updates"),
 *   description = @Translation("Drupal core and contrib project update status data."),
 *   events = {"drupal"}
 * )
 */
class UpdateStatusCollector extends CollectorBase implements ModuleHandlerAwareInterface {

  use ModuleHandlerAwareTrait;

  /**
   * {@inheritdoc}
   */
  public function collect(array $data = []) {
    $data = $this->defaultResult();

    try {
      $this->moduleHandler->getModule('update');
    }
    catch (\InvalidArgumentException $e) {
      $data['code'] = 'update_not_enabled';
      $this->queue->add($data);
      return;
    }

    $data['projects'] = [];
    $data['status'] = [];

    if ($available = update_get_available(TRUE)) {
      module_load_include('inc', 'update', 'update.compare');
      $info = update_calculate_project_data($available);

      $status_map = [
        1 => 'not_secure',
        2 => 'revoked',
        3 => 'not_supported',
        4 => 'not_current',
        5 => 'current',
        -1 => 'not_checked',
        -2 => 'unknown',
        -3 => 'not_fetched',
        -4 => 'fetch_pending',
      ];

      foreach ($info as $project) {
        $status = $project['status'];
        if (isset($status_map[$status])) {
          $data['status'][$status_map[$status]][] = $project['name'];
        }
        $data['projects'][$project['name']] = $project['existing_version'];
      }
      $data['code'] = CollectorInterface::STATUS_SUCCESS;
    }
    else {
      $data['code'] = 'unable_to_get_update_data';
    }

    $this->queue->add($data);
  }

}
