# Get Template Part with Variables
A simple WordPress plugin that works like ```get_template_part()``` but allows you to pass variables to the rendered template.

The variables must be passed as an associative array where the keys would be valid variable names.

You should be careful to NOT use any variable names that WordPress includes automatically. The plugin will bring all of those defaults in first, and if the variable you pass to this function would overwrite an existing variable, an exception will be thrown.

Example:

```php
$variables = [
    'name' => 'John',
    'class' => 'featuredAuthor',
];

jpr_get_template_part_with_vars('author', 'info', $variables);


// In author-info.php:
echo "
<div class='$class'>
    <span>$name</span>
</div>
";

// Would output:
<div class='featuredAuthor'>
    <span>John</span>
</div>
```

