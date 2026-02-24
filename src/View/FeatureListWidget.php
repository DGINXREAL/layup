<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FeatureListWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'feature-list';
    }

    public static function getLabel(): string
    {
        return 'Feature List';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-check-circle';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('features')
                ->label('Features')
                ->schema([
                    TextInput::make('title')
                        ->label('Title')
                        ->required(),
                    TextInput::make('description')
                        ->label('Description')
                        ->nullable(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('icon_style')
                ->label('Icon Style')
                ->options([
                    'check' => '✓ Checkmark',
                    'arrow' => '→ Arrow',
                    'dot' => '● Dot',
                    'number' => '1. Numbered',
                ])
                ->default('check'),
            TextInput::make('icon_color')
                ->label('Icon Color')
                ->type('color')
                ->default('#22c55e'),
            Select::make('layout')
                ->label('Layout')
                ->options([
                    'list' => 'Vertical List',
                    'grid-2' => '2-Column Grid',
                    'grid-3' => '3-Column Grid',
                ])
                ->default('list'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'features' => [
                ['title' => 'Feature One', 'description' => 'A brief description of this feature.'],
                ['title' => 'Feature Two', 'description' => 'Another great feature explained.'],
                ['title' => 'Feature Three', 'description' => 'One more awesome capability.'],
            ],
            'icon_style' => 'check',
            'icon_color' => '#22c55e',
            'layout' => 'list',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['features'] ?? []);

        return "✓ Feature List ({$count} items)";
    }
}
