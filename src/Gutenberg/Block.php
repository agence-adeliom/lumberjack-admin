<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Gutenberg;

use Extended\ACF\Fields\Field;
use Extended\ACF\Location;

/**
 * @internal
 */
class Block
{
    /**
     * @var \Traversable|null
     */
    public ?\Traversable $fields;
    /**
     * The directory name of the block.
     *
     * @var string $name
     */
    protected string $name = '';

    /**
     * The display name of the block.
     *
     * @var string $title
     */
    protected string $title = '';

    /**
     * The description of the block.
     *
     * @var string $description
     */
    protected string $description;

    /**
     * The category this block belongs to.
     *
     * @var string $category
     */
    protected string $category;

    /**
     * The icon of this block.
     *
     * @var string $icon
     */
    protected string $icon = '';

    /**
     * An array of keywords the block will be found under.
     *
     * @var array $keywords
     */
    protected array $keywords = [];

    /**
     * An array of Post Types the block will be available to.
     *
     * @var array $post_types
     */
    protected array $post_types = ['post', 'page'];

    /**
     * The default display mode of the block that is shown to the user.
     *
     * @var string $mode
     */
    protected string $mode = 'preview';

    /**
     * The block alignment class.
     *
     * @var string $align
     */
    protected string $align = '';

    /**
     * The block alignment class.
     *
     * @var string $align_text
     */
    protected string $align_text = '';

    /**
     * The block alignment class.
     *
     * @var string $align_content
     */
    protected string $align_content = '';

    /**
     * Features supported by the block.
     *
     * @var array $supports
     */
    protected array $supports = [
        'multiple' => true,
        'align' => false,
        'align_text' => false,
        'align_content' => false,
        'jsx' => false
    ];

    /**
     * Preview example.
     *
     * @var array $example
     */
    protected array $example = [
        'attributes' => [
            'mode' => 'preview',
            'data' => [
                "content" => [
                    'img_preview' => true
                ]
            ]
        ]
    ];

    /**
     * The blocks directory path.
     *
     * @var string $dir
     */
    public string $dir;

    /**
     * The blocks accessibility.
     *
     * @var bool $enabled
     */
    protected bool $enabled = true;

    /**
     * The blocks assets.
     *
     */
    public ?array $assets;

    /**
     * Begin block construction!
     *
     * @param array $settings The block definitions.
     * @since 0.10
     */
    public function __construct(array $settings)
    {
        // Path related definitions.
        $reflection = new \ReflectionClass($this);
        $block_path = $reflection->getFileName();
        $directory_path = dirname($block_path);
        $this->name = strtolower(preg_replace('#(?<!^)[A-Z]#', '-$0', basename($block_path, '.php')));
        // User definitions.
        $this->enabled = $settings['enabled'] ?? true;
        $this->assets = $settings['enqueue_assets'] ?? null;
        $this->dir = $settings['dir'] ?? $directory_path;
        $this->icon = $settings['icon'] ?? apply_filters('acf_gutenblocks/default_icon', 'admin-generic');
        $this->mode = $settings['mode'] ?? $this->getMode();
        $this->example = $settings['example'] ?? $this->getExample();
        $this->align = $settings['align'] ?? $this->getAlignment();
        $this->align_content = $settings['align_content'] ?? $this->getAlignmentContent();
        $this->align_text = $settings['align_text'] ?? $this->getAlignmentText();
        $this->supports = isset($settings['supports']) && is_array($settings['supports']) ? array_merge($settings['supports'], $this->getSupports()) : $this->getSupports();
        $settings = apply_filters('acf_gutenblocks/block_settings', [
            'title' => $settings['title'],
            'description' => $settings['description'],
            'category' => $settings['category'],
            'icon' => $this->icon,
            'supports' => $this->supports,
            'post_types' => $settings['post_types'] ?? $this->post_types,
        ], $this->name);
        $this->title = $settings['title'];
        $this->description = $settings['description'];
        $this->category = $settings['category'];
        $this->icon = $settings['icon'];
        $this->post_types = $settings['post_types'];
        // Set ACF Fields to the block.
        $this->fields = $this->registerFields();
    }

    /**
     * Is the block enabled?
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Add context to block
     * @return array
     */
    public function addToContext(): array
    {
        return [];
    }

    /**
     * User defined ACF fields
     *
     * @return \Traversable|null
     */
    protected function registerFields(): ?\Traversable
    {
        return null;
    }

    /**
     * Get the block ACF fields
     *
     * @return Field[]
     */
    public function getFields(): array
    {
        if($this->fields){
            return iterator_to_array($this->fields, false);
        }

        return [];
    }

    /**
     * Get the block name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the block title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the block description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the block category
     *
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * Get the block icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Get the block keywords
     *
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * Get the block post types
     *
     * @return array
     */
    public function getPostTypes(): array
    {
        return $this->post_types;
    }

    /**
     * Get the block mode
     *
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Get the block alignment
     *
     * @return string
     */
    public function getAlignment(): string
    {
        return $this->align;
    }

    /**
     * Get the text alignment
     *
     * @return string
     */
    public function getAlignmentText(): string
    {
        return $this->align_text;
    }

    /**
     * Get the content alignment
     *
     * @return string
     */
    public function getAlignmentContent(): string
    {
        return $this->align_content;
    }

    /**
     * Get featured supported by the block
     *
     * @return array
     */
    public function getSupports(): array
    {
        return $this->supports;
    }

    /**
     * Get example for preview
     *
     * @return array
     */
    public function getExample(): array
    {
        return $this->example;
    }

    /**
     * Get the block registration data
     *
     * @return array
     */
    public function getBlockData(): array
    {
        return [
            'name' => $this->getName(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'category' => $this->getCategory(),
            'icon' => $this->getIcon(),
            'keywords' => $this->getKeywords(),
            'post_types' => $this->getPostTypes(),
            'mode' => $this->getMode(),
            'example' => $this->getExample(),
            'align' => $this->getAlignment(),
            'align_text' => $this->getAlignmentText(),
            'align_content' => $this->getAlignmentContent(),
            'supports' => $this->getSupports(),
            'enqueue_assets' => $this->assets,
            'render_callback' => [$this, 'renderBlockCallback'],
        ];
    }

    public function init(): void
    {
        if (function_exists('acf_register_block_type') && function_exists('register_extended_field_group')) {
            $fields = $this->getFields();
            acf_register_block_type($this->getBlockData());
            if (!empty($fields)) {
                register_extended_field_group([
                    'title' => "Block - " . $this->getTitle(),
                    'fields' => $fields,
                    'location' => [
                        Location::where("block", "==", "acf/" . $this->getName())
                    ],
                ]);
            }
        }
    }
}
