<?php

class App_Controller {
  function authenticate($auth) {
    if ($auth == APP_AUTH) {
      return true;
    }

    return false;
  }
}
