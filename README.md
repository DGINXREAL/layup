# Layup

A visual page builder plugin for [Filament 5](https://filamentphp.com). Divi-style grid editor with rows, columns, and extensible widgets.

## Features

- **12-column grid** with responsive breakpoints (sm/md/lg/xl)
- **Visual span picker** — click-to-set column widths per breakpoint
- **Drag & drop** — reorder widgets and rows
- **Undo/Redo** — Ctrl+Z / Ctrl+Shift+Z with full history stack
- **Inline row insertion** — hover-reveal insert zones between rows
- **Row & widget duplication** — one-click cloning
- **Extensible widget system** — interface contract with lifecycle hooks

### Built-in Widgets

| Widget | Category | Description |
|--------|----------|-------------|
| Text | Content | Rich text content |
| Heading | Content | H1–H6 headings |
| Image | Media | Image with alt text and link |
| Video | Media | YouTube/Vimeo embeds with aspect ratio control |
| Button | Content | Styled buttons with links |
| HTML | Content | Raw HTML |
| Spacer | Layout | Configurable vertical spacing |
| Divider | Layout | Horizontal rules with style options |

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

## Configuration

Publish the config:

```bash
php artisan vendor:publish --tag=layup-config
```

### Custom Widgets

Create a widget by implementing `Crumbls\Layup\Contracts\Widget` or extending `Crumbls\Layup\Widgets\BaseWidget`:

```php
use Crumbls\Layup\Widgets\BaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MyWidget extends BaseWidget
{
    public static function getType(): string { return 'my-widget'; }
    public static function getLabel(): string { return 'My Widget'; }
    public static function getCategory(): string { return 'custom'; }

    public static function schema(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
        ]);
    }

    public static function getPreview(array $data): string
    {
        return e($data['title'] ?? 'My Widget');
    }
}
```

Register via plugin:

```php
LayupPlugin::make()
    ->widgets([MyWidget::class])
```

Or remove defaults:

```php
LayupPlugin::make()
    ->withoutWidgets(['html', 'spacer'])
```

## License

MIT
