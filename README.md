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
    
    public static function getTitle(): string
    {
        return 'Post edit interface';
    }
    
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
    
    public static function getTitle(): string
    {
        return 'Options';
    }
    
    /**
     * @see https://github.com/vinkla/extended-acf#fields
     * @return Traversable
     */
    public static function getFields(): Traversable
    {
        yield Text::make('Gtag code', 'gtag');
    }
    
    /**
     * Register has option page
     */
    public static function hasOptionPage(): bool
    {
        return true;
    }
}
```

Check the full class declaration at [src/AbstractAdmin.php](src/AbstractAdmin.php)

## Create a ACF Gutenberg block

```php
<?php

namespace App\Blocks;

use Adeliom\Lumberjack\Admin\AbstractBlock;
use Extended\ACF\Fields\WysiwygEditor;use Traversable;

class WysiwygBlock extends AbstractBlock
{
    
    public function __construct()
    {
        parent::__construct([
            'title' => __('Text Editor'),
            'description' => __('Simple HTML content')
        ]);
    }
    
    /**
     * @see https://github.com/vinkla/extended-acf#fields
     * @return Traversable
     */
    public static function getFields(): Traversable
    {
        yield WysiwygEditor::make('HTML Content', 'content');
    }
}
```

The twig template attached to this block is `views/block/wysiwyg.html.twig`.

## License
Lumberjack Admin is released under [the MIT License](LICENSE).


