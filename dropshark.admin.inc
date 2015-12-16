<?php

/**
 * @file
 * DropShark administrative pages.
 */

/**
 * Administrative configuration page.
 */
function dropshark_admin_config($form, &$form_state) {

  if (!$token = variable_get('dropshark_site_token')) {
    $form_state['storage']['step'] = 'token';

    $form['instructions']['#markup'] = t('In order to register your site with the DropShark service, you\'ll need to enter your credentials and site identifier.');
    $form['instructions']['#prefix'] = '<p>';
    $form['instructions']['#suffix'] = '</p>';

    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => t('Email address'),
      '#description' => t('Enter the email address which you\'ve registered for DropShark.'),
      '#required' => TRUE,
    );

    $form['password'] = array(
      '#type' => 'password',
      '#title' => t('DropShark password'),
      '#description' => t('Enter your DropShark password.'),
      '#required' => TRUE,
    );

    $form['site_id'] = array(
      '#type' => 'textfield',
      '#title' => t('Site ID'),
      '#description' => t('Find your site identifier on your DropShark dashboard.'),
      '#default_value' => variable_get('dropshark_site_id'),
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#value' => t('Register site'),
      '#type' => 'submit',
    );
  } else {
    $params['!link'] = l('DropShark', 'http://dashboard.dropshark.io');
    $form['instructions']['#markup'] = t('Your site is registered and will send data to DropShark. Log in to !link to analyze your data.', $params);
    $form['instructions']['#prefix'] = '<p>';
    $form['instructions']['#suffix'] = '</p>';

    $form['status'] = array(
      '#type' => 'item',
      '#title' => t('Site ID'),
      '#markup' => check_plain(variable_get('dropshark_site_id')),
    );
  }

  return $form;
}

/**
 * Form validation for dropshark_admin_config.
 */
function dropshark_admin_config_validate($form, &$form_state) {

  if ($form_state['storage']['step'] == 'token') {
    $r = new DropSharkRequestDefault();
    $data['user'] = $form_state['values']['email'];
    $data['password'] = $form_state['values']['password'];
    $data['site_id'] = $form_state['values']['site_id'];
    $result = $r->post('sites/token', $data);

    if (empty($result->data->token)) {
      if (!empty($result->data->error)) {
        $params['@message'] = $result->data->error;
        $message = t('Unable to register your site: @message. Please check your information and try again. If you continue to experience issues, please contact DropShark support.', $params);
      } else {
        $message = t('Unable to register your site, please check your information and try again. If you continue to experience issues, please contact DropShark support.');
      }
      form_set_error('', $message);
    } else {
      $form_state['storage']['token'] = $result->data->token;
    }
  }

}

/**
 * Form submit handler for dropshark_admin_config.
 */
function dropshark_admin_config_submit(&$form, &$form_state) {

  if ($form_state['storage']['step'] == 'token') {
    variable_set('dropshark_site_id', $form_state['values']['site_id']);
    variable_set('dropshark_site_token', $form_state['storage']['token']);
  }

}
