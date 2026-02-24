<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class TimelineWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'timeline';
    }

    public static function getLabel(): string
    {
        return 'Timeline';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-clock';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('events')
                ->label('Timeline Events')
                ->schema([
                    TextInput::make('date')
                        ->label('Date / Label')
                        ->required(),
                    TextInput::make('title')
                        ->label('Title')
                        ->required(),
                    TextInput::make('description')
                        ->label('Description')
                        ->nullable(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            TextInput::make('line_color')
                ->label('Line Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'events' => [
                ['date' => '2024', 'title' => 'Founded', 'description' => 'Started the journey.'],
                ['date' => '2025', 'title' => 'Growth', 'description' => 'Scaled to 1000 users.'],
                ['date' => '2026', 'title' => 'Today', 'description' => 'Serving customers worldwide.'],
            ],
            'line_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['events'] ?? []);

        return "📅 Timeline ({$count} events)";
    }
}
