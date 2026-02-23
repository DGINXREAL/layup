<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class AccordionWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'accordion';
    }

    public static function getLabel(): string
    {
        return 'Accordion';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-bars-3-bottom-left';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('items')
                ->label('Items')
                ->schema([
                    TextInput::make('title')
                        ->label('Title')
                        ->required(),
                    RichEditor::make('content')
                        ->label('Content')
                        ->columnSpanFull(),
                ])
                ->defaultItems(2)
                ->collapsible()
                ->columnSpanFull(),
            Toggle::make('open_first')
                ->label('Open first item by default')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'items' => [
                ['title' => 'Item 1', 'content' => ''],
                ['title' => 'Item 2', 'content' => ''],
            ],
            'open_first' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['items'] ?? []);

        return "▾ Accordion · {$count} items";
    }
}
