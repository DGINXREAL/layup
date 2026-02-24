<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;

class Section extends BaseView
{
    /**
     * Section wraps one or more rows and provides background styling.
     * Content structure: { sections: [{ id, settings, rows: [...] }] }
     */
    public static function getFormSchema(?string $statePath = null): array
    {
        return [
            Tabs::make('section_settings')
                ->tabs([
                    Tabs\Tab::make('Content')
                        ->schema(static::getContentFormSchema())
                        ->columns(2),
                    Tabs\Tab::make('Design')
                        ->schema(static::getDesignFormSchema())
                        ->columns(2),
                    Tabs\Tab::make('Advanced')
                        ->schema(static::getAdvancedFormSchema())
                        ->columns(2),
                ]),
        ];
    }

    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('background_image')
                ->label('Background Image')
                ->image()
                ->directory('layup/sections'),
            TextInput::make('background_video')
                ->label('Background Video URL')
                ->url()
                ->placeholder('https://example.com/video.mp4')
                ->nullable(),
            TextInput::make('background_gradient')
                ->label('Background Gradient')
                ->placeholder('linear-gradient(135deg, #667eea 0%, #764ba2 100%)')
                ->nullable(),
            TextInput::make('overlay_color')
                ->label('Overlay Color')
                ->type('color')
                ->default('#000000'),
            TextInput::make('overlay_opacity')
                ->label('Overlay Opacity (0-100)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->default(0),
            Toggle::make('parallax')
                ->label('Parallax Effect')
                ->default(false),
            Select::make('min_height')
                ->label('Minimum Height')
                ->options([
                    '' => 'Auto',
                    '50vh' => 'Half Screen',
                    '75vh' => 'Three-Quarter Screen',
                    '100vh' => 'Full Screen',
                ])
                ->default(''),
            Toggle::make('full_width')
                ->label('Full Width (no container)')
                ->default(false),
        ];
    }

    public static function getDesignFormSchema(): array
    {
        return parent::getDesignFormSchema();
    }

    public static function getAdvancedFormSchema(): array
    {
        return parent::getAdvancedFormSchema();
    }

    /**
     * Build inline styles for section wrapper.
     */
    public static function buildSectionStyles(array $settings): string
    {
        $styles = [];

        if (! empty($settings['background_color'])) {
            $styles[] = "background-color: {$settings['background_color']}";
        }

        if (! empty($settings['background_gradient'])) {
            $styles[] = "background: {$settings['background_gradient']}";
        }

        if (! empty($settings['background_image']) && empty($settings['background_video'])) {
            $url = asset('storage/' . $settings['background_image']);
            $styles[] = "background-image: url('{$url}')";
            $styles[] = 'background-size: cover';
            $styles[] = 'background-position: center';
            if (! empty($settings['parallax'])) {
                $styles[] = 'background-attachment: fixed';
            }
        }

        if (! empty($settings['min_height'])) {
            $styles[] = "min-height: {$settings['min_height']}";
        }

        if (! empty($settings['inline_css'])) {
            $styles[] = $settings['inline_css'];
        }

        return implode('; ', $styles);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('layup::components.section');
    }
}
