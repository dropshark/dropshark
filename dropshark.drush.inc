<?php

/**
 * @file
 * DropShark drush integration.
 */

/**
 * Implements hook_drush_command().
 */
function dropshark_drush_command() {
  $commands['dropshark-collect'] = array(
    'description' => 'Collect and send data to the DropShark service.',
    'aliases' => array('drpshrk'),
  );

  return $commands;
}

/**
 * Drush worker callback for collecting
 */
function drush_dropshark_collect() {
  dropshark_handle_event('all');
  dropshark_queue_process();
  drush_log(dt('Collection complete.'), 'ok');
}
