<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class NumberCounterWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'number-counter';
    }

    public static function getLabel(): string
    {
        return 'Number Counter';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('number')
                ->label('Number')
                ->numeric()
                ->required()
                ->default(100),
            TextInput::make('prefix')
                ->label('Prefix')
                ->placeholder('e.g. $')
                ->nullable(),
            TextInput::make('suffix')
                ->label('Suffix')
                ->placeholder('e.g. % or +')
                ->nullable(),
            TextInput::make('title')
                ->label('Title')
                ->nullable(),
            Toggle::make('animate')
                ->label('Animate on scroll')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'number' => 100,
            'prefix' => '',
            'suffix' => '',
            'title' => '',
            'animate' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $prefix = $data['prefix'] ?? '';
        $number = $data['number'] ?? 0;
        $suffix = $data['suffix'] ?? '';
        $title = $data['title'] ?? '';

        return "🔢 {$prefix}{$number}{$suffix}" . ($title ? " — {$title}" : '');
    }
}
