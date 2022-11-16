<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Fields\Tabs\Traits;

trait Fields
{
    public function fields(array $fields): \Generator
    {
        foreach ($fields as $field) {
            yield $field;
        }
    }
}
