<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class ComparisonTableWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'comparison-table';
    }

    public static function getLabel(): string
    {
        return 'Comparison Table';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-scale';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('column_a')
                ->label('Column A Header')
                ->default('Us')
                ->required(),
            TextInput::make('column_b')
                ->label('Column B Header')
                ->default('Them')
                ->required(),
            Repeater::make('rows')
                ->label('Comparison Rows')
                ->schema([
                    TextInput::make('feature')
                        ->label('Feature')
                        ->required(),
                    TextInput::make('value_a')
                        ->label('Column A Value')
                        ->default('✓'),
                    TextInput::make('value_b')
                        ->label('Column B Value')
                        ->default('✗'),
                ])
                ->defaultItems(5)
                ->columnSpanFull(),
            TextInput::make('highlight_color')
                ->label('Highlight Color (Column A)')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'column_a' => 'Us',
            'column_b' => 'Them',
            'rows' => [],
            'highlight_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        $a = $data['column_a'] ?? 'A';
        $b = $data['column_b'] ?? 'B';

        return "⚖️ {$a} vs {$b}";
    }
}
