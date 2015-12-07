<?php

class DropSharkMemoryCollector extends DropSharkCollectorBase {

  /**
   * {@inheritdoc}
   */
  public function collect($context = array()) {

    $data = array();

    $memory = $this->get_data();

    if (empty($memory['Mem:'])) {
      $data['code'] = 1;
      return $data;
    }

    $memory = $memory['Mem:'];

    $data['code'] = 0;
    $data['free'] = $memory['free'];
    $data['used'] = $memory['used'];
    $data['cached'] = $memory['cached'];
    $data['total'] = $memory['total'];
    $data['used_percent_nocache'] = $memory['used'] / $memory['total'];
    $data['used_percent'] = ($memory['used'] - $data['cached']) / $memory['total'];

    return $data;
  }

  /**
   * Get memory usage information from the OS.
   *
   * @return array
   *  Memory usage information, keyed by type ("Mem:", "Swap:").
   */
  protected function get_data() {
    static $data = NULL;

    if ($data === NULL) {
      $cmd = array_map('trim', explode("\n", `free`));

      $header = array_shift($cmd);
      $header = 'type ' . strtolower($header);

      $format = '%s %s %s %s %s %s %s';
      $header =  sscanf($header, $format);

      $data = array();
      foreach ($cmd as $line) {
        if ($line = sscanf($line, $format)) {
          $line = array_combine($header, $line);
          $data[$line['type']] = $line;
        }
      }
    }

    return $data;
  }

}
