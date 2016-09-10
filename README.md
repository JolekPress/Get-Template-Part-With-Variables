# Get Template Part with Variables
A simple WordPress plugin that works like ```get_template_part()``` but allows you to pass variables to the rendered template.

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

