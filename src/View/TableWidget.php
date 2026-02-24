<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TableWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'table';
    }

    public static function getLabel(): string
    {
        return 'Table';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-table-cells';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('caption')
                ->label('Caption')
                ->nullable(),
            Repeater::make('headers')
                ->label('Headers')
                ->simple(
                    TextInput::make('text')
                        ->label('Header')
                        ->required(),
                )
                ->defaultItems(3)
                ->columnSpanFull(),
            Repeater::make('rows')
                ->label('Rows')
                ->schema([
                    Repeater::make('cells')
                        ->label('Cells')
                        ->simple(
                            TextInput::make('text')
                                ->label('Cell')
                                ->required(),
                        )
                        ->defaultItems(3)
                        ->columnSpanFull(),
                ])
                ->defaultItems(2)
                ->columnSpanFull(),
            Toggle::make('striped')
                ->label('Striped rows')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'caption' => '',
            'headers' => ['Column 1', 'Column 2', 'Column 3'],
            'rows' => [
                ['cells' => ['Data 1', 'Data 2', 'Data 3']],
                ['cells' => ['Data 4', 'Data 5', 'Data 6']],
            ],
            'striped' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $cols = count($data['headers'] ?? []);
        $rows = count($data['rows'] ?? []);

        return "📊 Table ({$cols} cols × {$rows} rows)";
    }
}
