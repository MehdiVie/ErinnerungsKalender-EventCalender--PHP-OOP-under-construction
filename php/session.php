<?php
require_once __DIR__ . '/load_env.php';
loadEnv(__DIR__ . '/../.env');
// php/session.php

// in production and real server true
$IS_PROD = getenv('APP_ENV') === 'production'; 

// in dev mode should be empty 
$domain = $IS_PROD ? 'erinnerungskalender.example' : '';
$secure = $IS_PROD; // only in production is true

// cookie session parameter
$cookieParams = [

    'lifetime' => 0,

    'path'     => '/',

    'domain'   => $domain, 

    'secure'   => $secure, 

    'httponly' => true,

    'samesite' => 'Lax' 
];

session_set_cookie_params($cookieParams);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
