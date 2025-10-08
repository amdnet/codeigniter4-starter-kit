<?php

/**
 * app\Helpers\crb_recaptcha_helper.php
 * app\Controllers\Auth\LoginController.php
 * app\Controllers\Auth\MagicLinkController.php
 * app\Controllers\Auth\RegisterController.php
*/
function recaptcha_field()
{
    $siteKey = setting('App.gSiteKey');
    return '<div class="g-recaptcha" data-sitekey="' . $siteKey . '"></div>';
}

/**
 * Verify reCAPTCHA response with Google API
 */
function recaptcha_verify(string $response): bool
{
    $secretKey = setting('App.gSecretKey');
    $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';

    $data = [
        'secret'   => $secretKey,
        'response' => $response,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $result   = file_get_contents($verifyURL, false, $context);
    $resultObj = json_decode($result);

    return $resultObj->success ?? false;
}