# kirby-uniform-recaptcha
An extension to the [Kirby 2 plugin uniform](http://getkirby-plugins.com/uniform) to add the Google recaptcha guard.

## Installation
1. Copy the `uniform-recaptcha` directory to `site/plugins`
2. Define the mandatory config settings:
  1. `c::set('uniform-recaptcha-sitekey', 'YOUR RECAPTCHA SITEKEY');`
  2. `c::set('uniform-recaptcha-secret', 'YOUR RECAPTCHA SECRET');`
  
## Usage
You can use the `recaptcha` guard in your controllers form definition:

```php
$form = uniform(
    'form-id',
    array(
        ...
        'guard' => 'recaptcha'
    )
);
```

To embed the recaptcha field into your template simply call
`<?php echo recaptcha_field(); ?>`

The plugin needs the recaptcha Javascript File provided by Google. You can either include the [Javascript File](https://www.google.com/recaptcha/api.js) directly into your page or by calling the method `embed_recaptcha_js()` in your template.

**Example**
```php
<form action="<?php echo $page->url()?>#form" method="post">
    <label for="name" class="required">Name</label>
    <input<?php e($form->hasError('name'), ' class="erroneous"')?> type="text" name="name" id="name" value="<?php $form->echoValue('name') ?>" required/>
    
    ...
    
    <div>
        <?php echo recaptcha_field(); ?>
    </div>
    
    ...
</form>
<?php echo embed_recaptcha_js(); ?>
```

## Author
Johannes Pichler [https://www.jopic.at](https://www.jopic.at)
