# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

`agence-adeliom/lumberjack-admin` is a **read-only Composer library** (MIT) that registers WordPress admin interfaces and ACF Gutenberg blocks for projects built on the [Rareloop Lumberjack](https://github.com/Rareloop/lumberjack) framework (Timber + WordPress). It is consumed *inside a theme*, not run standalone — there is no build, test, or lint tooling in this repo, and no `composer scripts`.

## Commands

**All commands must go through DDEV** — prefix every command with `ddev` (e.g. `ddev composer require ...`, `ddev composer dump-autoload`, `ddev wp ...`). Do not run `composer`, `php`, or `wp` directly on the host.

- PSR-4: `Adeliom\Lumberjack\Admin\` → `src/`
- Requires PHP ≥ 8.0.2, `rareloop/lumberjack-core`, `vinkla/extended-acf` (field declaration), `symfony/string`.
- ACF fields are declared with extended-acf's fluent API (`Text::make(...)`, `Location::where(...)`); see https://github.com/vinkla/extended-acf.

## Architecture

The whole package is wired through one entry point: `AdminProvider` (a Lumberjack `ServiceProvider`, registered by the consuming theme in `config/app.php`).

**`AdminProvider::boot()`** does auto-discovery against the *consuming theme*, not this repo:
- Scans `<theme>/app/Admin` for `AbstractAdmin` subclasses and `<theme>/app/Block` for `Block`/`AbstractBlock` subclasses, `include`s each PHP file, then registers matches found via `get_declared_classes()` + reflection.
- **Ordering matters**: non-sub-option-page admins register before sub-option pages (`IS_SUB_OPTION_PAGE`), so an option subpage's parent menu exists first. Preserve this split if you touch `registerAdmin()`.
- Wires Gutenberg hooks (`TemplateHooks`, `RestrictionsHooks`) and merges custom block categories from `config('gutenberg.categories')`.

**`AbstractAdmin`** (`src/AbstractAdmin.php`) — declares an ACF field group bound to a post type, options page, or sub-option page. Subclass defines `getFields()` (+ optionally `getLocation()`); behavior is driven by class constants: `TITLE`, `IS_OPTION_PAGE`, `IS_SUB_OPTION_PAGE`, `PARENT_SLUG`. `register()` calls extended-acf's `register_extended_field_group()` and, for option pages, `acf_add_options_page` / `acf_add_options_sub_page`. The slug is auto-derived from `TITLE` via `AsciiSlugger`.

**`AbstractBlock`** (`src/AbstractBlock.php`) extends **`Gutenberg\Block`** — an ACF Gutenberg block rendered through Timber/Twig. Driven by constants `NAME` (must be **kebab-case** — enforced at construction, throws otherwise), `TITLE`, `DESCRIPTION`. Convention-based asset paths (overridable via constructor `$settings`):
- Template: `views/blocks/{name}.html.twig` (the `-block` suffix is stripped from `name`)
- Preview image: `assets/images/admin/gutenberg-blocks/{name}/preview.jpg`
- Icon: `assets/images/admin/gutenberg-blocks/{name}/picto.svg`

`renderBlockCallback()` builds the Timber context (`block`, `fields`, `controller`, …). A subclass may define `with()` (custom field data) and/or `addToContext()` (extra context). In the admin, if a block has a `preview.jpg`, it renders that image instead of the template.

**The `__add()` guard** (in both abstracts): any inherited constant still equal to the string `"abstract"` throws a `RuntimeException` — this is how the library forces subclasses to define required constants. When adding a new required constant to an abstract, default it to `"abstract"`.

**Hooks** (`src/Hooks/`):
- `RestrictionsHooks::allowedBlock` (filter `allowed_block_types_all`) — computes the allow/deny block list. Patterns support three forms, also used by `config('gutenberg.settings.disable_blocks')`: a regex (`/(core|yoast)\/\w*/`), a wildcard array (`['core/*', 'yoast/breadcrumb']`), and a `!`-prefix to *exclude/keep* (`!core/embed`).
- `TemplateHooks` — applies per-target block templates (`template`, `template_lock`) and can disable Gutenberg per target.

**Per-target Gutenberg config** is resolved by `Helpers\GutenbergBlock::getObjectSettings()`, which layers `config('gutenberg.templates')` keys in increasing specificity: `*` (wildcard) → post type → page template slug → post ID → `{postType}-{postId}`. Later keys override earlier ones.

## Config

The package ships `config/gutenberg.php`; the consuming theme copies it to `<theme>/config/gutenberg.php`. Keys: `categories`, `settings.disable_blocks`, and `templates` (keyed by post type / template file / id / `{type}-{id}`, each with `enabled`, `blocks`, `template`, `template_lock`). Full semantics are documented in `README.md`.

## Field library

`src/Fields/` is a catalog of reusable extended-acf field wrappers grouped by domain (`Typography/`, `Medias/`, `Choices/`, `Relations/`, `Tabs/`, `Layout/`, `Buttons/`, `Settings/`). Each is a thin subclass of an extended-acf field exposing a static factory `make()` (and sometimes helpers like `HeadingField::tag()` that compose a `Group`). Labels/instructions in these classes are **in French** — match that when extending. See `src/Fields/README.md` for the visual catalog.