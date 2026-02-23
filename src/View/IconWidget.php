<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class IconWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'icon';
    }

    public static function getLabel(): string
    {
        return 'Icon';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-star';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('icon')
                ->label('Icon Name')
                ->required()
                ->placeholder('e.g. heroicon-o-heart'),
            TextInput::make('color')
                ->label('Color')
                ->type('color')
                ->nullable(),
            Select::make('size')
                ->label('Size')
                ->options([
                    '1.5rem' => 'Small',
                    '2.5rem' => 'Medium',
                    '4rem' => 'Large',
                    '6rem' => 'Extra Large',
                    '8rem' => 'Huge',
                ])
                ->default('2.5rem'),
            TextInput::make('url')
                ->label('Link URL')
                ->url()
                ->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'icon' => '',
            'color' => '',
            'size' => '2.5rem',
            'url' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        $icon = $data['icon'] ?? '';

        return $icon ? "✦ {$icon}" : '(no icon)';
    }
}
