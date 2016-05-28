<?php

namespace SocialHelper\Error;

class Error
{
    private $errors;
    private $error;

    private function getErrors()
    {
        $errors = file_get_contents('errors.json', true);
        $this->errors = json_decode($errors);
    }

    public function __construct($error_code = 0)
    {
        $this->getErrors();
        
        if (!isset($this->errors->$error_code)) {
            $error_code = 2;
        }

        $json = $this->errors->$error_code;
        $json =  (array) $json;
        $json['error'] = true;
        $json['code'] = $error_code;

        $this->error = $json;
    }

    public function getError()
    {
        return $this->error;
    }
}
