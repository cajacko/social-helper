<?php

function action_err($message) {
    $response = array('err' => true, 'err' => $message);;
    echo json_encode($response);
}

if(isset($_GET['action'], $_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
} elseif(isset($_POST['action'], $_POST['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
} else {
    action_err('No action or ID specified');
    exit;
}

require_once('../models/database.php');
require_once('../models/action.php');

$action_model = new Action($db);
$response = $action_model->process_action($action, $id);

if($response) {
    echo json_encode($response);
} else {
    action_err('Bad response');
}

exit;
