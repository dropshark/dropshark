<?php

class DropSharkMemoryCollector extends DropSharkCollectorBase {

  protected $events = array('system');

  /**
   * {@inheritdoc}
   */
  public function collect($event, $data = array()) {

    if (!$this->respond($event)) {
      return DropSharkCollector::RESPONSE_NONE;
    }

    $data = array('type' => 'memory');
    $data['server'] = $this->getServer();

    $memory = $this->getData();

    if (empty($memory['Mem:'])) {
      $data['code'] = 'unable_to_determine_memory';
      dropshark_queue_data($data);
      return DropSharkCollector::RESPONSE_COMPLETE;
    }

    $memory = $memory['Mem:'];

    $data['code'] = 0;
    $data['free'] = $memory['free'];
    $data['used'] = $memory['used'];
    $data['cached'] = $memory['cached'];
    $data['total'] = $memory['total'];
    $data['used_percent_nocache'] = $memory['used'] / $memory['total'];
    $data['used_percent'] = ($memory['used'] - $data['cached']) / $memory['total'];

    dropshark_queue_data($data);
    return $data;
  }

  /**
   * Get memory usage information from the OS.
   *
   * @return array
   *  Memory usage information, keyed by type ("Mem:", "Swap:").
   */
  protected function getData() {
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
