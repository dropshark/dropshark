<?php

/**
 * @file
 * Hooks provided by the DropShark module.
 */

/**
 * Define DropSharkCollector classes provided by the module.
 *
 * @return array
 *   An array of collector definitions, keyed by machine name.
 */
function hook_dropshark_collector_info() {
  $collectors['php_version'] = array(
    'class' => 'PhpVersionCollector',
  );

  return $collectors;
}

/**
 * Alter DropSharkCollector class definitions.
 *
 * @param array $collectors
 *   An array of collector definitions, keyed by machine name.
 *
 * @see hook_dropshark_collector_info()
 */
function hook_dropshark_collector_info_alter(array &$collectors) {
  $collectors['php_version']['class'] = 'CustomPhpVersionCollector';
}
