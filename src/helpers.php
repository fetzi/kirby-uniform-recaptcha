<?php

use Uniform\Guards\RecaptchaGuard;
use Uniform\Exceptions\Exception as UniformException;

if (!function_exists('recaptcha_field')) {
    /**
     * Generate a reCAPTCHA form field.
     *
     * @return string
     */
    function recaptcha_field()
    {
        $key = c::get(RecaptchaGuard::SITEKEY_KEY);

        if (empty($key)) {
            throw new UniformException('The reCAPTCHA sitekey is not configured.');
        }

        return '<div class="g-recaptcha" data-sitekey="'.$key.'"></div>';
    }
}

if (!function_exists('embed_recaptcha_js')) {
    /**
     * Generate script tag that includes the reCAPTCHA JavaScript file.
     *
     * @return string
     */
    function embed_recaptcha_js()
    {
        return '<script src="https://www.google.com/recaptcha/api.js"></script>';
    }
}
