<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BadgeWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'badge';
    }

    public static function getLabel(): string
    {
        return 'Badge';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-tag';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('text')->label('Text')->required(),
            Select::make('variant')->label('Variant')->options([
                'default' => 'Default', 'success' => 'Success', 'warning' => 'Warning',
                'danger' => 'Danger', 'info' => 'Info', 'dark' => 'Dark',
            ])->default('default'),
            Select::make('size')->label('Size')->options([
                'sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large',
            ])->default('md'),
            TextInput::make('link_url')->label('Link URL')->url()->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['text' => '', 'variant' => 'default', 'size' => 'md', 'link_url' => ''];
    }

    public static function getPreview(array $data): string
    {
        return '🏷 ' . ($data['text'] ?? 'Badge');
    }
}
