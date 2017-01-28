<?php

require_once('db.php');

class Accounts_Model {
  public static function get_accounts() {
    $query = '
      SELECT *
      FROM accounts
    ';

    return Db::get_rows($query);
  }
}
