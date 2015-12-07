<?php

class DropSharkDrupalStatusCollector extends DropSharkCollectorBase {

  /**
   * {@inheritdoc}
   */
  public function collect($context = array()) {

    // Load .install files
    include_once DRUPAL_ROOT . '/includes/install.inc';
    drupal_load_updates();

    // Check run-time requirements and status information.
    $requirements = module_invoke_all('requirements', 'runtime');
    ksort($requirements);

    // Count number of requirements at each status.
    $severities = array(
      REQUIREMENT_ERROR => 0,
      REQUIREMENT_INFO => 0,
      REQUIREMENT_OK => 0,
      REQUIREMENT_WARNING => 0,
      'none' => 0,
    );
    foreach ($requirements as $requirement) {
      if (isset($requirement['severity'])) {
        $severities[$requirement['severity']]++;
      } else {
        $severities['none']++;
      }
    }

    $data['code'] = 0;
    $data['requirements'] = $requirements;
    $data['severity'] = $severities;

    return $data;
  }

}
