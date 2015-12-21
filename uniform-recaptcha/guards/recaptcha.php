<?php
const RECAPTCHA_KEY = "g-recaptcha-response";
const RECAPTCHA_SITEKEY_CONFIG = "uniform-recaptcha-sitekey";
const RECAPTCHA_SECRET_CONFIG = "uniform-recaptcha-secret";
const RECAPTCHA_URL = "https://www.google.com/recaptcha/api/siteverify";

Uniform::$guards['recaptcha'] = function(UniForm $form)
{
    $recaptchaValue = $form->value(RECAPTCHA_KEY);

    if(!empty($recaptchaValue)) {
        $secret = c::get(RECAPTCHA_SECRET_CONFIG);
        $recaptchaUrl = RECAPTCHA_URL . '?secret=' . $secret . '&response=' . $recaptchaValue;

        $response = file_get_contents($recaptchaUrl);
        $response = json_decode($response, true);

        if(empty($response) || $response['success'] !== true) {
            return [
                'success' => false,
                'message' => l::get('uniform-recaptcha-invalid'),
                'clear' => false
            ];
        }
    }
    else {
        return [
            'success' => false,
            'message' => l::get('uniform-recaptcha-empty'),
            'clear' => false
        ];
    }

    $form->removeField(RECAPTCHA_KEY);

    return [ 'success' => true ];
};

function recaptcha_field() {
    return '<div class="g-recaptcha" data-sitekey="' . c::get(RECAPTCHA_SITEKEY_CONFIG) . '"></div>';
}

function embed_recaptcha_js() {
    return '<script src="https://www.google.com/recaptcha/api.js"></script>';
}