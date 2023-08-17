<?php

return [
    'min_password' => 8,
    'url_reset_password' =>  env('APP_URL_RESET_PASSWORD', ''),
    'url_verify_password' =>  env('APP_URL_VERIFY_PASSWORD', ''),
    'response_status_errors' => 'errors',
    'response_status_verifi' => 'verifi',
    'response_status_invalid' => 'invalid',
];