<?php

function is_twitter_callback_test($request)
{
    global $config;

    if (!$config->dev) {
        echo 'not dev';
        return false;
    }

    if (!isset($request[2])) {
        echo 'No 2nd url param';
        return false;
    }

    if ($config->testsVars->twitterLoginEchoResults->callbackAppendUrl != $request[2]) {
        echo '2nd url param not valid';
        return false;
    }

    return true;
}
