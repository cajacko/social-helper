<?php

namespace SocialHelper\Error;

class Error
{
    private $errors;

    public function getError()
    {
        $errors = file_get_contents('errors.json', true);
        $this->errors = json_decode($errors);
    }

    public function __construct($error_code = 0)
    {
        $this->getError();
        
        $json = $this->errors->$error_code;
        $json =  (array) $json;
        $json['error'] = true;
        $json['code'] = $error_code;

        echo json_encode($json);
    }
}
