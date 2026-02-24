<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ProgressCircleWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'progress-circle';
    }

    public static function getLabel(): string
    {
        return 'Progress Circle';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-arrow-path';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('percent')
                ->label('Percentage')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->default(75)
                ->required(),
            TextInput::make('title')
                ->label('Title')
                ->nullable(),
            TextInput::make('color')
                ->label('Circle Color')
                ->type('color')
                ->default('#3b82f6'),
            TextInput::make('size')
                ->label('Size (px)')
                ->numeric()
                ->default(120),
            TextInput::make('stroke_width')
                ->label('Stroke Width (px)')
                ->numeric()
                ->default(8),
            Toggle::make('animate')
                ->label('Animate on scroll')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'percent' => 75,
            'title' => '',
            'color' => '#3b82f6',
            'size' => 120,
            'stroke_width' => 8,
            'animate' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        return "⭕ {$data['percent']}%";
    }
}
