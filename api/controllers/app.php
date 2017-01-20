<?php

class App {
  function authenticate($auth) {
    if ($auth == APP_AUTH) {
      return true;
    }

    return false;
  }
}
