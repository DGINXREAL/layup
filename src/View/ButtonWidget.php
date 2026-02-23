<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ButtonWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'button';
    }

    public static function getLabel(): string
    {
        return 'Button';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-cursor-arrow-rays';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('label')
                ->label('Button Text')
                ->required()
                ->default('Click Me'),
            TextInput::make('url')
                ->label('URL')
                ->url(),
            Select::make('style')
                ->label('Style')
                ->options([
                    'primary' => 'Primary',
                    'secondary' => 'Secondary',
                    'outline' => 'Outline',
                    'ghost' => 'Ghost',
                ])
                ->default('primary'),
            Select::make('size')
                ->label('Size')
                ->options([
                    'sm' => 'Small',
                    'md' => 'Medium',
                    'lg' => 'Large',
                ])
                ->default('md'),
            Toggle::make('new_tab')
                ->label('Open in new tab')
                ->default(false),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'label' => 'Click Me',
            'url' => '#',
            'style' => 'primary',
            'size' => 'md',
            'new_tab' => false,
        ];
    }

    public static function getPreview(array $data): string
    {
        $label = $data['label'] ?? 'Button';
        $url = $data['url'] ?? '#';

        return "🔘 {$label}" . ($url !== '#' ? " → {$url}" : '');
    }
}
