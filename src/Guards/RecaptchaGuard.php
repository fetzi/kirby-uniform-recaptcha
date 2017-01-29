<?php

namespace Uniform\Guards;

use L;
use C as Config;
use R as Request;
use ErrorException;
use Uniform\Exceptions\Exception;

/**
 * Guard that uses Google reCAPTCHA.
 */
class RecaptchaGuard extends Guard
{
    /**
     * Captcha field name
     *
     * @var string
     */
    const FIELD_NAME = 'g-recaptcha-response';

    /**
     * Config key for the reCAPTCHA sitekey
     *
     * @var string
     */
    const SITEKEY_KEY = 'uniform-recaptcha-sitekey';

    /**
     * Config key for the reCAPTCHA secret
     *
     * @var string
     */
    const SECRET_KEY = 'uniform-recaptcha-secret';

    /**
     * ReCAPTCHA URL
     *
     * @var string
     */
    const URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Load the translation file for the current language
     */
    public static function loadTranslation()
    {
        if (defined('KIRBY')) {
            $site = kirby()->site();
            $code = $site->multilang()
                ? $site->language()->code()
                : Config::get('uniform.language', 'en');

            try {
                include_once __DIR__.DS.'..'.DS.'..'.DS.'languages'.DS.$code.'.php';
            } catch (ErrorException $e) {
                throw new Exception("Uniform reCAPTCHA does not have a translation for the language '$code'.");
            }
        }
    }

    /**
     * {@inheritDoc}
     * Check if the captcha field was filled in correctly
     * Remove the field from the form data if it was correct.
     */
    public function perform()
    {
        static::loadTranslation();

        $recaptchaValue = Request::postData(self::FIELD_NAME);

        if (empty($recaptchaValue)) {
            $this->reject(L::get('uniform-recaptcha-empty'), self::FIELD_NAME);
        }

        $secret = Config::get(self::SECRET_KEY);

        if (empty($secret)) {
            throw new Exception('The reCAPTCHA secret is not configured.');
        }

        $recaptchaUrl = self::URL.'?secret='.$secret.'&response='.$recaptchaValue;

        $response = json_decode(file_get_contents($recaptchaUrl), true);

        if (empty($response) || $response['success'] !== true) {
            $this->reject(L::get('uniform-recaptcha-invalid'), self::FIELD_NAME);
        }

        $this->form->forget(self::FIELD_NAME);
    }
}
