<?php

declare(strict_types=1);

namespace Adeliom\Lumberjack\Admin\Gutenberg;

use Adeliom\Lumberjack\Admin\Helpers\GutenbergBlock;
use Extended\ACF\Fields\Field;
use Extended\ACF\Location;

use function Symfony\Component\String\u;

/**
 * @internal
 */
class Block
{
    public const NAME = null;
    public const TITLE = null;
    public const DESCRIPTION = null;

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
    protected string $category = "common";

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
    protected array $post_types = [];

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
    public ?\Closure $assets;

    /**
     * Begin block construction!
     *
     * @param array $settings The block definitions.
     * @since 0.10
     */
    public function __construct(?array $settings = [])
    {
        // Path related definitions.
        $reflection = new \ReflectionClass($this);
        $block_path = $reflection->getFileName();
        $directory_path = dirname($block_path);

        $settings['enabled'] = $settings['enabled'] ?? true;
        $settings['enqueue_assets'] = $settings['enqueue_assets'] ?? null;
        $settings['icon'] = $settings['icon'] ?? apply_filters('acf_gutenblocks/default_icon', 'admin-generic');
        $settings['dir'] = $settings['dir'] ?? $directory_path;
        $settings['post_types'] = $settings['post_types'] ?? $this->getPostTypes();
        $settings['mode'] = $settings['mode'] ?? $this->getMode();
        $settings['example'] = $settings['example'] ?? $this->getExample();
        $settings['align'] = $settings['align'] ?? $this->getAlignment();
        $settings['align_content'] = $settings['align_content'] ?? $this->getAlignmentContent();
        $settings['align_text'] = $settings['align_text'] ?? $this->getAlignmentText();
        $settings['category'] = $settings['category'] ?? $this->getCategory();
        $settings['supports'] = isset($settings['supports']) && is_array($settings['supports']) ? array_merge($this->getSupports(), $settings['supports']) : $this->getSupports();

        $settings = apply_filters('acf_gutenblocks/block_settings', $settings, static::NAME);

        $settings['name'] = static::NAME;
        $settings['title'] = static::TITLE;
        $settings['description'] = static::DESCRIPTION;

        if (!preg_match('/^([a-z](?![\d])|[\d](?![a-z]))+(-?([a-z](?![\d])|[\d](?![a-z])))*$|^$/', self::name())) {
            $instead = u(self::name())->snake()->replace("_", "-")->toString();
            throw new \RuntimeException(sprintf("The block name '%s' in %s is not a valid format. You must use kebab-case for block name. May be you should use '%s'", self::name(), static::class, $instead));
        }

        if (GutenbergBlock::isAlreadyRegistered(self::key())) {
            throw new \RuntimeException(sprintf("An other block with name '%s' is already defined", self::name()));
        }

        // User definitions.
        $this->title = $settings['title'];
        $this->name = $settings['name'];
        $this->enabled = $settings['enabled'];
        $this->assets = $settings['enqueue_assets'];
        $this->dir = $settings['dir'];
        $this->mode = $settings['mode'];
        $this->example = $settings['example'];
        $this->align = $settings['align'];
        $this->align_content = $settings['align_content'];
        $this->align_text = $settings['align_text'];
        $this->supports = $settings['supports'];
        $this->description = $settings['description'];
        $this->category = $settings['category'];
        $this->icon = $settings['icon'];
        $this->post_types = $settings['post_types'];

        // Set ACF Fields to the block.
        $this->fields = static::getFields();
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
     * @see https://github.com/vinkla/extended-acf#fields
     * @return \Traversable|null
     */
    public static function getFields(): ?\Traversable
    {
        return null;
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

    public function iconExtension(): string
    {
        return '.svg';
    }

    public function previewExtension(): string
    {
        return '.jpg';
    }

    public function fileExtension(): string
    {
        return '.html.twig';
    }

    public function isValid(): bool
    {
        return class_exists("Timber") && !GutenbergBlock::isAlreadyRegistered(self::key());
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
            $fields = [];
            if ($this->fields) {
                $fields = iterator_to_array($this->fields, false);
            }
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

    public static function key(): string
    {
        return sprintf('%s/%s', GutenbergBlock::ACF_BLOCK_PREFIX, static::NAME);
    }

    public static function name(): string
    {
        return static::NAME;
    }
}
