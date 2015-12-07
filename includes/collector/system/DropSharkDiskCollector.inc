<?php

/**
 * Class DropSharkDiskCollector.
 */
class DropSharkDiskCollector extends DropSharkCollectorBase {

  /**
   * {@inheritdoc}
   */
  public function collect($context = array()) {
    $data = array();

    if (empty($context['drive']) || !in_array($context['drive'], $this->get_disks())) {
      $data['code'] = 1;
      return $data;
    }

    $disk = $this->get_data();
    $disk = $disk[$context['drive']];

    $data['code'] = 0;
    $data['free'] = $disk['available'];
    $data['used'] = $disk['used'];
    $data['total'] = $data['free'] + $data['used'];
    $data['used_percent'] = $data['used'] / $data['total'];

    return $data;
  }

  /**
   * Gets information for the disks on the machine.
   *
   * @return array
   *   Data representing the existence and utilization of disks on the machine.
   */
  public function get_data() {
    static $data = NULL;

    if ($data === NULL) {
      $cmd = array_map('trim', explode("\n", `df`));

      $header = array_shift($cmd);
      $replace = array(
        '-' => '_',
        'mounted on' => 'mounted_on',
        'use%' => 'use_percent',
      );
      $header = strtr(strtolower($header), $replace);

      $format = '%s %s %s %s %s %s';
      $header =  sscanf($header, $format);

      $data = array();

      foreach ($cmd as $line) {
        if ($line = sscanf($line, $format)) {
          $line = array_combine($header, $line);
          $data[$line['mounted_on']] = $line;
        }
      }
    }

    return $data;
  }

  /**
   * Lists disks on the machine.
   *
   * @return array
   *   Mount points for disks on the machine.
   */
  public function get_disks() {
    return array_keys($this->get_data());
  }

}
