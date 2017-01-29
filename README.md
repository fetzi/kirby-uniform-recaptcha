# kirby-uniform-recaptcha

An extension to the Kirby 2 plugin [Uniform](https://github.com/mzur/kirby-uniform) (v3) to add the Google reCAPTCHA guard.

## Installation

### Kirby CLI

Get the [Kirby CLI](https://github.com/getkirby/cli) and run `kirby plugin:install fetzi/kirby-uniform-recaptcha`.

### Traditional

[Download](https://github.com/fetzi/kirby-uniform-recaptcha/archive/master.zip) the repository and extract it to `site/plugins/uniform-recaptcha`.

### Composer

Run `composer require fetzi/kirby-uniform-recaptcha`. Then add the second `require` to the `index.php` like this:

```php
// load kirby
require(__DIR__ . DS . 'kirby' . DS . 'bootstrap.php');
require 'vendor'.DS.'autoload.php';
```

Be sure to include the new `vendor` directory in your deployment.

## Configuration

Define the mandatory config settings:

1. `c::set('uniform-recaptcha-sitekey', 'YOUR RECAPTCHA SITEKEY');`
2. `c::set('uniform-recaptcha-secret', 'YOUR RECAPTCHA SECRET');`

## Usage

You can use the `recaptchaGuard` in your controllers form definition:

```php
$form = new Form(/* ... */);

if (r::is('POST')) {
    $form->recaptchaGuard()
        ->emailAction(/* ... */);
}
```

To embed the recaptcha field into your template simply call
`<?php echo recaptcha_field(); ?>`

The plugin needs the recaptcha Javascript File provided by Google. You can either include the [JavaScript file](https://www.google.com/recaptcha/api.js) directly into your page or by calling the method `embed_recaptcha_js()` in your template.

**Example**
```html+php
<form action="<?php echo $page->url()?>" method="post">
    <label for="name" class="required">Name</label>
    <input<?php if ($form->error('name')): ?> class="erroneous"<?php endif; ?> name="name" type="text" value="<?php echo $form->old('name') ?>">

    <!-- ... -->

    <?php echo csrf_field() ?>
    <?php echo recaptcha_field() ?>
    <input type="submit" value="Submit">
</form>
<?php echo embed_recaptcha_js(); ?>
```

## Author

Johannes Pichler [https://www.jopic.at](https://www.jopic.at)
