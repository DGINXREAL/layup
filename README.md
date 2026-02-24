# Layup

A visual page builder plugin for [Filament](https://filamentphp.com). Divi-style editor with rows, columns, and 39 extensible widgets — all using native Filament form components.

## Features

- **Flex-based 12-column grid** with responsive breakpoints (sm/md/lg/xl)
- **Visual span picker** — click-to-set column widths per breakpoint
- **Drag & drop** — reorder widgets and rows
- **Undo/Redo** — Ctrl+Z / Ctrl+Shift+Z with full history stack
- **Widget picker modal** — searchable, categorized, grid layout
- **Three-tab form schema** — Content / Design / Advanced on every component
- **Full Design tab** — text color, alignment, font size, border, border radius, box shadow, opacity, background color, padding, margin
- **Responsive visibility** — show/hide per breakpoint on any element
- **Entrance animations** — fade in, slide up/down/left/right, zoom in (via Alpine x-intersect)
- **Frontend rendering** — configurable routes, layouts, and SEO meta (OG, Twitter Cards, canonical, JSON-LD)
- **Tailwind safelist** — automatic class collection for dynamic content
- **Page templates** — 5 built-in templates (blank, landing, about, contact, pricing) + save your own
- **Content revisions** — auto-save on content change, configurable max, restore from history
- **Export / Import** — pages as JSON files
- **Widget lifecycle hooks** — `onSave`, `onCreate`, `onDelete` with optional context
- **Content validation** — structural + widget type validation
- **Widget auto-discovery** — scans `App\Layup\Widgets` for custom widgets
- **Configurable model** — swap the Page model per dashboard
- **503 tests, 1003 assertions**

### Built-in Widgets (39)

| Category | Widgets |
|----------|---------|
| **Content** | Text, Heading, Blurb, Icon, Accordion, Toggle, Tabs, Person, Testimonial, Number Counter, Bar Counter, Alert, Table, Progress Circle, Blockquote, Feature List, Timeline, Stat Card, Star Rating, Logo Grid, Menu |
| **Media** | Image (with hover effects), Gallery (with lightbox), Video, Audio, Slider, Map |
| **Interactive** | Button (hover colors), Call to Action, Countdown, Pricing Table, Social Follow, Search, Contact Form |
| **Layout** | Spacer, Divider |
| **Advanced** | HTML, Code Block, Embed |

## Requirements

- PHP 8.2+
- Laravel 12+
- Filament 5
- Livewire 4

## Installation

```bash
composer require crumbls/layup
```

Publish and run migrations:

```bash
php artisan migrate
```

Register the plugin in your Filament panel:

```php
use Crumbls\Layup\LayupPlugin;

->plugins([
    LayupPlugin::make(),
])
```

Publish the config (optional):

```bash
php artisan vendor:publish --tag=layup-config
```

## Frontend Rendering

Layup includes an optional frontend controller that serves pages at a configurable URL prefix.

### Enable Frontend Routes

In `config/layup.php`:

```php
'frontend' => [
    'enabled' => true,
    'prefix'  => 'pages',       // → yoursite.com/pages/{slug}
    'middleware' => ['web'],
    'domain'  => null,           // Restrict to a specific domain
    'layout'  => 'layouts.app',  // Blade component layout
    'view'    => 'layup::frontend.page',
],
```

The `layout` value is passed to `<x-dynamic-component>`, so it should be a Blade component name. For example:

- `'layouts.app'` → `resources/views/components/layouts/app.blade.php`
- `'app-layout'` → `App\View\Components\AppLayout`

Your layout must include `{{ $slot }}` where the page content should render.

### Nested Slugs

Pages support nested slugs via wildcard routing:

```
/pages/about          → slug: about
/pages/about/team     → slug: about/team
```

## Tailwind CSS Integration

Layup generates Tailwind utility classes dynamically — column widths like `w-6/12`, `md:w-3/12`, gap values, and any custom classes users add via the Advanced tab. Since Tailwind scans source files (not databases), these classes need to be safelisted.

### How It Works

Layup provides two layers of class collection:

1. **Static classes** — Every possible Tailwind utility the plugin can generate (column widths × 4 breakpoints, flex utilities, gap values). These are finite and ship with the package.
2. **Dynamic classes** — Custom classes users type into the "CSS Classes" field on any row, column, or widget's Advanced tab.

Both are merged into a single safelist file.

### Quick Setup

**1. Generate the safelist file:**

```bash
php artisan layup:safelist
```

This writes `storage/layup-safelist.txt` with all classes (static + from published pages).

**2. Add to your CSS (Tailwind v4):**

```css
/* resources/css/app.css */
@import "tailwindcss";
@source "../../storage/layup-safelist.txt";
```

**3. Build:**

```bash
npm run build
```

That's it. All Layup classes will be included in your compiled CSS.

### Tailwind v3

If you're on Tailwind v3, add the safelist file to your `tailwind.config.js`:

```js
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './storage/layup-safelist.txt',
    ],
    // ...
}
```

### Build Pipeline Integration

Add the safelist command to your build script so it always runs before Tailwind compiles:

```json
{
    "scripts": {
        "build": "php artisan layup:safelist && vite build"
    }
}
```

Or in a deploy script:

```bash
php artisan layup:safelist
npm run build
```

### Auto-Sync on Save

By default, Layup regenerates the safelist file every time a page is saved. If new classes are detected, it dispatches a `SafelistChanged` event.

```php
'safelist' => [
    'enabled'   => true,   // Enable safelist generation
    'auto_sync' => true,   // Regenerate on page save
    'path'      => 'storage/layup-safelist.txt',
],
```

#### Listening for Changes

Use the `SafelistChanged` event to trigger a rebuild, send a notification, or log the change:

```php
use Crumbls\Layup\Events\SafelistChanged;

class HandleSafelistChange
{
    public function handle(SafelistChanged $event): void
    {
        // $event->added   — array of new classes
        // $event->removed — array of removed classes
        // $event->path    — path to the safelist file

        logger()->info('Layup safelist changed', [
            'added'   => $event->added,
            'removed' => $event->removed,
        ]);

        // Trigger a rebuild, notify the team, etc.
    }
}
```

Register in your `EventServiceProvider`:

```php
protected $listen = [
    \Crumbls\Layup\Events\SafelistChanged::class => [
        \App\Listeners\HandleSafelistChange::class,
    ],
];
```

#### How Change Detection Works

Layup uses Laravel's cache (any driver — file, Redis, database, array) to store a hash of the last known class list. On page save, it regenerates the list, compares the hash, and only dispatches the event if something actually changed.

The safelist file write is **best-effort** — if the filesystem is read-only (serverless, containerized deploys), the write silently fails but the event still fires. You can listen for the event and handle the rebuild however your infrastructure requires.

#### Disabling Auto-Sync

If you don't want safelist regeneration on every save (e.g., in production where you build once at deploy time):

```php
'safelist' => [
    'auto_sync' => false,
],
```

You'll need to run `php artisan layup:safelist` manually or as part of your deploy pipeline.

### Command Options

```bash
# Default: write to storage/layup-safelist.txt
php artisan layup:safelist

# Custom output path
php artisan layup:safelist --output=resources/css/layup-classes.txt

# Print to stdout (pipe to another tool)
php artisan layup:safelist --stdout

# Static classes only (no database query — useful in CI)
php artisan layup:safelist --static-only
```

### What Gets Safelisted

| Source | Classes | Example |
|--------|---------|---------|
| Column widths | `w-{n}/12` × 4 breakpoints | `w-6/12`, `md:w-4/12`, `lg:w-8/12` |
| Flex utilities | `flex`, `flex-wrap` | Always included |
| Gap values | `gap-{0-12}` | `gap-4`, `gap-8` |
| User classes | Anything in the "CSS Classes" field | `my-hero`, `bg-blue-500` |

Widget-specific classes (like `layup-widget-text`, `layup-accordion-item`) are **not** Tailwind utilities — they're styled by Layup's own CSS and don't need safelisting.

## Frontend Scripts

Layup's interactive widgets (accordion, tabs, toggle, countdown, slider, counters) use Alpine.js components. By default, the required JavaScript is inlined automatically via the `@layupScripts` directive.

### Auto-Include (default)

No setup needed. The scripts are injected inline on any page that uses `@layupScripts` (included in the default page view).

```php
// config/layup.php
'frontend' => [
    'include_scripts' => true,  // default
],
```

### Bundle Yourself

If you'd rather include the scripts in your own Vite build (for caching, minification, etc.), disable auto-include and import the file:

```php
// config/layup.php
'frontend' => [
    'include_scripts' => false,
],
```

```js
// resources/js/app.js
import '../../vendor/crumbls/layup/resources/js/layup.js'
```

### Publish and Customize

```bash
php artisan vendor:publish --tag=layup-scripts
```

This copies `layup.js` to `resources/js/vendor/layup.js` where you can modify it.

### Available Alpine Components

| Component | Widget | Parameters |
|-----------|--------|------------|
| `layupAccordion` | Accordion | `(openFirst = true)` |
| `layupToggle` | Toggle | `(open = false)` |
| `layupTabs` | Tabs | none |
| `layupCountdown` | Countdown | `(targetDate)` |
| `layupSlider` | Slider | `(total, autoplay, speed)` |
| `layupCounter` | Number Counter | `(target, animate)` |
| `layupBarCounter` | Bar Counter | `(percent, animate)` |

## Custom Widgets

Create a widget by extending `Crumbls\Layup\View\BaseWidget`:

```php
use Crumbls\Layup\View\BaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;

class MyWidget extends BaseWidget
{
    public static function getType(): string { return 'my-widget'; }
    public static function getLabel(): string { return 'My Widget'; }
    public static function getIcon(): string { return 'heroicon-o-cube'; }
    public static function getCategory(): string { return 'custom'; }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('data.title')->label('Title')->required(),
            RichEditor::make('data.content')->label('Content'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => '',
            'content' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        return $data['title'] ?: '(empty)';
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('widgets.my-widget', ['data' => $this->data]);
    }
}
```

The form schema automatically inherits Design (spacing, background) and Advanced (id, class, inline CSS) tabs from `BaseWidget`. You only define the Content tab.

### Register via config

```php
// config/layup.php
'widgets' => [
    // ... built-in widgets ...
    \App\Layup\MyWidget::class,
],
```

### Register via plugin

```php
LayupPlugin::make()
    ->widgets([MyWidget::class])
```

### Remove built-in widgets

```php
LayupPlugin::make()
    ->withoutWidgets([
        \Crumbls\Layup\View\HtmlWidget::class,
        \Crumbls\Layup\View\SpacerWidget::class,
    ])
```

## Configuration Reference

```php
// config/layup.php
return [
    // Widget classes available in the page builder
    'widgets' => [ /* ... */ ],

    // Page model and table name (swap per dashboard)
    'pages' => [
        'table' => 'layup_pages',
        'model' => \Crumbls\Layup\Models\Page::class,
    ],

    // Frontend rendering
    'frontend' => [
        'enabled'    => true,
        'prefix'     => 'pages',
        'middleware'  => ['web'],
        'domain'     => null,
        'layout'     => 'layouts.app',
        'view'       => 'layup::frontend.page',
    ],

    // Tailwind safelist
    'safelist' => [
        'enabled'   => true,
        'auto_sync' => true,
        'path'      => 'storage/layup-safelist.txt',
    ],

    // Frontend container class (applied to each row's inner wrapper)
    // Use 'container' for Tailwind's default, or 'max-w-7xl', etc.
    'max_width' => 'container',

    // Responsive breakpoints
    'breakpoints' => [
        'sm' => ['label' => 'sm', 'width' => 640,  'icon' => 'heroicon-o-device-phone-mobile'],
        'md' => ['label' => 'md', 'width' => 768,  'icon' => 'heroicon-o-device-tablet'],
        'lg' => ['label' => 'lg', 'width' => 1024, 'icon' => 'heroicon-o-computer-desktop'],
        'xl' => ['label' => 'xl', 'width' => 1280, 'icon' => 'heroicon-o-tv'],
    ],

    'default_breakpoint' => 'lg',

    // Row layout presets (column spans, must sum to 12)
    'row_templates' => [
        [12], [6, 6], [4, 4, 4], [3, 3, 3, 3],
        [8, 4], [4, 8], [3, 6, 3], [2, 8, 2],
    ],
];
```

## Multiple Dashboards

To use Layup across multiple Filament panels with separate page tables:

```php
// Panel A
LayupPlugin::make()
    ->model(PageA::class)    // or set via config

// Panel B — different table
LayupPlugin::make()
    ->model(PageB::class)
```

Your custom model just overrides `getTable()`:

```php
class PageB extends \Crumbls\Layup\Models\Page
{
    public function getTable(): string
    {
        return 'my_other_pages_table';
    }
}
```

## License

MIT
