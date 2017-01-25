<?php

require_once('../helpers/error-response.php');
require_once('../models/cron.php');

class Cron_Controller {
  function get_cron($user_id) {
    $cron = Cron_Model::get_user_cron($user_id);

    if (!$cron) {
      return false;
    }

    if (!$cron['cron']) {
      return false;
    }

    return $cron['cron'];
  }

  function update($user, $cron) {
    $user_id = $user->get_user_id();

    if (!$user_id) {
      return error_response(38);
    }

    if (!Cron_Model::set_user_cron($user_id, $cron)) {
      return error_response(39);
    }

    return $user->read();
  }
}
