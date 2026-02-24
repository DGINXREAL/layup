<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class IconBoxWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'icon-box';
    }

    public static function getLabel(): string
    {
        return 'Icon Box';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-square-3-stack-3d';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('icon')
                ->label('Icon (emoji or text)')
                ->default('⚡')
                ->required(),
            TextInput::make('title')
                ->label('Title')
                ->required(),
            TextInput::make('description')
                ->label('Description')
                ->nullable(),
            TextInput::make('link_url')
                ->label('Link URL')
                ->url()
                ->nullable(),
            TextInput::make('icon_bg')
                ->label('Icon Background Color')
                ->type('color')
                ->default('#eff6ff'),
            TextInput::make('icon_color')
                ->label('Icon Color')
                ->type('color')
                ->default('#3b82f6'),
            Select::make('alignment')
                ->label('Alignment')
                ->options(['left' => 'Left', 'center' => 'Center', 'top' => 'Top (icon above)'])
                ->default('top'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'icon' => '⚡',
            'title' => '',
            'description' => '',
            'link_url' => '',
            'icon_bg' => '#eff6ff',
            'icon_color' => '#3b82f6',
            'alignment' => 'top',
        ];
    }

    public static function getPreview(array $data): string
    {
        return ($data['icon'] ?? '⚡') . ' ' . ($data['title'] ?? '');
    }
}
