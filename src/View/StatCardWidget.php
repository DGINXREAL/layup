<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class StatCardWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'stat-card';
    }

    public static function getLabel(): string
    {
        return 'Stat Card';
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
            TextInput::make('value')
                ->label('Value')
                ->placeholder('$1.2M')
                ->required(),
            TextInput::make('label')
                ->label('Label')
                ->placeholder('Revenue')
                ->required(),
            TextInput::make('description')
                ->label('Description / Change')
                ->placeholder('+12% from last month')
                ->nullable(),
            Select::make('trend')
                ->label('Trend')
                ->options([
                    '' => 'None',
                    'up' => '↑ Up (green)',
                    'down' => '↓ Down (red)',
                    'neutral' => '→ Neutral (gray)',
                ])
                ->default('')
                ->nullable(),
            TextInput::make('accent_color')
                ->label('Accent Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'value' => '',
            'label' => '',
            'description' => '',
            'trend' => '',
            'accent_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        return ($data['value'] ?? '') . ' ' . ($data['label'] ?? '');
    }
}
