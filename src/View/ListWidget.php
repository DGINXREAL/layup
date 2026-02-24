<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ListWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'list';
    }

    public static function getLabel(): string
    {
        return 'List';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-list-bullet';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('items')
                ->label('List Items')
                ->simple(
                    TextInput::make('text')->required()
                )
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('style')
                ->label('List Style')
                ->options([
                    'bullet' => '• Bullets',
                    'number' => '1. Numbered',
                    'check' => '✓ Checkmarks',
                    'arrow' => '→ Arrows',
                    'none' => 'No markers',
                ])
                ->default('bullet'),
            TextInput::make('icon_color')
                ->label('Marker Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'items' => ['First item', 'Second item', 'Third item'],
            'style' => 'bullet',
            'icon_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['items'] ?? []);
        return "• List ({$count} items)";
    }
}
