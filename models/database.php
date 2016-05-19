<?php

$db = new mysqli(
  $config->config->database->host, 
  $config->config->database->user, 
  $config->config->database->password, 
  $config->config->database->database
);

$db->set_charset('utf8mb4'); 
