<?php

if(!class_exists('UniForm')) {
    throw new \Exception('The Uniform plugin is missing.');
}

if(empty(c::get('uniform-recaptcha-sitekey'))) {
    throw new \Exception('The sitekey is not defined in configuration.');
}

if(empty(c::get('uniform-recaptcha-secret'))) {
    throw new \Exception('The secret key is not defined in the configuration.');
}

$languagesDir = __DIR__ . DS . 'languages' . DS;
$language = site()->multilang() ? site()->languages()->findDefault()->code() : c::get('uniform.language', 'en');

if(!file_exists($languagesDir . $language . '.php')) {
    $language = 'en';
}
require_once $languagesDir . $language . '.php';

require_once __DIR__ . DS . 'guards' . DS . 'recaptcha.php';