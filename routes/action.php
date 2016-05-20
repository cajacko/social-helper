<?php

function action_err($message) {
    $response = array('err' => true, 'err' => $message);;
    echo json_encode($response);
}

if(isset($request[1])) {
    switch($request[1]) {
        case 'ajax':
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
            break;
        case 'add-tag':
            require_once('../models/database.php');
            require_once('../models/tags.php');

            if(isset($_POST['tag'])) {
                $tags = new Tags($db);
                $response = $tags->add_user_tags($_POST['tag']);

                if($response) {
                    header('Location: /');
                    exit;
                } else {
                    header('Location: /?error');
                    exit;
                }
            } else {
                header('Location: /?error');
                exit;
            }

            break;
        case 'delete-tag':
            require_once('../models/database.php');
            require_once('../models/tags.php');

            if(isset($_GET['id']) && is_numeric($_GET['id'])) {
                $tags = new Tags($db);
                $response = $tags->delete_user_tag($_GET['id']);

                if($response) {
                    header('Location: /');
                    exit;
                } else {
                    header('Location: /?error');
                    exit;
                }
            } else {
                header('Location: /?error');
                exit;
            }

            break;
        default:
            action_err('Unknown action');
            exit;
    }
} else {
    action_err('No action specified');
    exit;
}
