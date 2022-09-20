# [READ-ONLY] Lumberjack Admin

Register WordPress Admin ans ACF block interfaces.

## Requirements

* PHP 8.0 or greater
* Composer
* Lumberjack

## Installation

```bash
composer require agence-adeliom/lumberjack-admin

# Copy the configuration file
cp vendor/agence-adeliom/lumberjack-admin/config/gutenberg.php web/app/themes/YOUR_THEME/config/gutenberg.php
```

### Register the service provider into web/app/themes/YOUR_THEME/config/app.php

```php
'providers' => [
    ...
    \Adeliom\Lumberjack\Admin\AdminProvider::class
]
```

## Usage

## Create an admin interface like for Options pages or Custom Post Types

### Create your admin class to manage post types :

```php
<?php

namespace App\Admin;

use Adeliom\Lumberjack\Admin\AbstractAdmin;
use Traversable;

class PostAdmin extends AbstractAdmin
{
    public const TITLE = "Post edit interface";
    
    /**
     * @see https://github.com/vinkla/extended-acf#fields
     * @return Traversable
     */
    public static function getFields(): Traversable
    {
        yield Text::make('Post subtitle', 'subtitle');
    }
    
    /**
     * @see https://github.com/vinkla/extended-acf#location
     */
    public static function getLocation(): Traversable
    {
        yield Location::where('post_type', '==', 'post');
    }
}
```

### Create your admin class to manage options :

```php
<?php

namespace App\Admin;

use Adeliom\Lumberjack\Admin\AbstractAdmin;
use Traversable;

class OptionsAdmin extends AbstractAdmin
{
    public const TITLE = "Options";
    public const IS_OPTION_PAGE = true;
    
    /**
     * User defined ACF fields
     * @see https://github.com/vinkla/extended-acf#fields
     * @return \Traversable|null
     */
    public static function getFields(): ?\Traversable
    {
        yield Text::make('Gtag code', 'gtag');
    }
}
```

Check the full class declaration at [src/AbstractAdmin.php](src/AbstractAdmin.php)

## Create a ACF Gutenberg block

```php
<?php

namespace App\Block;

use Adeliom\Lumberjack\Admin\AbstractBlock;
use Extended\ACF\Fields\WysiwygEditor;use Traversable;

class WysiwygBlock extends AbstractBlock
{

    public const NAME = "wysiwyg";
    public const TITLE = "Text Editor";
    public const DESCRIPTION = "Simple HTML content";

    /**
     * User defined ACF fields
     * @see https://github.com/vinkla/extended-acf#fields
     * @return \Traversable|null
     */
    public static function getFields(): ?\Traversable
    {
        yield WysiwygEditor::make('HTML Content', 'content');
    }
}
```

The twig template attached to this block is `views/block/wysiwyg.html.twig`.

## Edit Gutenberg settings

### Add new categories

```php
<?php
//web/app/themes/YOUR_THEME/config/gutenberg.php
return [
    'categories' => [
        ...
        "example" => [
            'title' => 'Examples', 
            'icon'  => 'images-alt'
        ]
    ],
    ...
];
```

### Globally disable blocks

```php
<?php
//web/app/themes/YOUR_THEME/config/gutenberg.php
return [
    ...
    'settings' => [
        ...
        "disable_blocks" => false
    ],
    ...
];
```

`disable_blocks` can handle multiple type :

* `false` mean that all blocks are allowed
* `a regex` you can use a regex to disallow every blocks matching this regex. ex. `/((core|yoast|yoast-seo|gravityforms)\/\w*)/`
* `a array` you can use a array with wildcards. ex: `[ 'core/*', 'yoast/breadcrumb' ]`

### Globally disable blocks

```php
<?php
//web/app/themes/YOUR_THEME/config/gutenberg.php
return [
    ...
    'settings' => [
        ...
        "disable_blocks" => false
    ],
    ...
];
```

`disable_blocks` can handle multiple type :

* `false` mean that all blocks are allowed
* `a regex` you can use a regex to disallow every blocks matching this regex. ex. `/((core|yoast|yoast-seo|gravityforms)\/\w*)/`
* `a array` you can use a array with wildcards. ex: `[ 'core/*', 'yoast/breadcrumb' ]`

### Configure Gutenberg

```php
<?php
//web/app/themes/YOUR_THEME/config/gutenberg.php
return [
    ...
    'templates' => [
        ...
        "disable_blocks" => false
    ],
    ...
];
```

`disable_blocks` can handle multiple type :

* `false` mean that all blocks are allowed
* `a regex` you can use a regex to disallow every blocks matching this regex. ex. `/((core|yoast|yoast-seo|gravityforms)\/\w*)/`
* `a array` you can use a array with wildcards. ex: `[ 'core/*', 'yoast/breadcrumb' ]`

## License
Lumberjack Admin is released under [the MIT License](LICENSE).


