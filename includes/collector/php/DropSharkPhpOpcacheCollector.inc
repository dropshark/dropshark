<?php

/**
 * Class DropSharkPhpOpcacheCollector.
 */
class DropSharkPhpOpcacheCollector extends DropSharkCollectorBase {

  public function collect($context = array()) {
    $data = array();

    if (!function_exists('opcache_get_status')) {
      $data['code'] = 1;
      return $data;
    }

    $data = opcache_get_status(FALSE);
    $data['code'] = 0;

    return $data;
  }

}
