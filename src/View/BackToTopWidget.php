<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BackToTopWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'back-to-top';
    }

    public static function getLabel(): string
    {
        return 'Back to Top';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-arrow-up';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('bg_color')
                ->label('Background Color')
                ->type('color')
                ->default('#3b82f6'),
            TextInput::make('text_color_btn')
                ->label('Icon Color')
                ->type('color')
                ->default('#ffffff'),
            Select::make('position')
                ->label('Position')
                ->options([
                    'right' => 'Bottom Right',
                    'left' => 'Bottom Left',
                ])
                ->default('right'),
            Select::make('size')
                ->label('Size')
                ->options(['sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large'])
                ->default('md'),
            TextInput::make('show_after')
                ->label('Show After Scroll (px)')
                ->numeric()
                ->default(300),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'bg_color' => '#3b82f6',
            'text_color_btn' => '#ffffff',
            'position' => 'right',
            'size' => 'md',
            'show_after' => 300,
        ];
    }

    public static function getPreview(array $data): string
    {
        return '⬆️ Back to Top button';
    }
}
