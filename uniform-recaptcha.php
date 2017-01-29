<?php

use Uniform\Guards\RecaptchaGuard;

// This file is called by Kirby if the plugin wasn't installed with Composer.
if (!class_exists(RecaptchaGuard::class)) {
	require __DIR__.DS.'src'.DS.'Guards'.DS.'RecaptchaGuard.php';
	require __DIR__.DS.'src'.DS.'helpers.php';
}
