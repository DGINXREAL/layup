<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class MetricWidget extends BaseWidget
{
    public static function getType(): string { return 'metric'; }
    public static function getLabel(): string { return 'Metrics Row'; }
    public static function getIcon(): string { return 'heroicon-o-chart-bar-square'; }
    public static function getCategory(): string { return 'content'; }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('metrics')
                ->label('Metrics')
                ->schema([
                    TextInput::make('value')->label('Value')->required()->placeholder('10K+'),
                    TextInput::make('label')->label('Label')->required()->placeholder('Users'),
                    TextInput::make('prefix')->label('Prefix')->nullable(),
                    TextInput::make('suffix')->label('Suffix')->nullable(),
                ])
                ->defaultItems(4)
                ->columnSpanFull(),
            Select::make('columns')
                ->label('Columns')
                ->options(['2' => '2', '3' => '3', '4' => '4', '5' => '5'])
                ->default('4'),
            Select::make('style')
                ->label('Style')
                ->options(['plain' => 'Plain', 'bordered' => 'Bordered', 'cards' => 'Cards'])
                ->default('plain'),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['metrics' => [
            ['value' => '10K+', 'label' => 'Users'],
            ['value' => '99.9%', 'label' => 'Uptime'],
            ['value' => '150+', 'label' => 'Countries'],
            ['value' => '24/7', 'label' => 'Support'],
        ], 'columns' => '4', 'style' => 'plain'];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['metrics'] ?? []);
        return "📊 Metrics ({$count})";
    }
}
