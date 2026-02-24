<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class SeparatorWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'separator';
    }

    public static function getLabel(): string
    {
        return 'Separator';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-minus';
    }

    public static function getCategory(): string
    {
        return 'layout';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Select::make('style')
                ->label('Style')
                ->options([
                    'line' => 'Simple Line',
                    'dots' => '● ● ● Dots',
                    'stars' => '★ ★ ★ Stars',
                    'diamond' => '◆ Diamond',
                    'wave' => '~ Wave',
                    'fade' => 'Fade (gradient)',
                ])
                ->default('line'),
            TextInput::make('color')
                ->label('Color')
                ->type('color')
                ->default('#d1d5db'),
            Select::make('width')
                ->label('Width')
                ->options([
                    '25%' => '25%',
                    '50%' => '50%',
                    '75%' => '75%',
                    '100%' => '100%',
                ])
                ->default('50%'),
            Select::make('spacing')
                ->label('Vertical Spacing')
                ->options([
                    '1rem' => 'Small',
                    '2rem' => 'Medium',
                    '3rem' => 'Large',
                    '4rem' => 'Extra Large',
                ])
                ->default('2rem'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'style' => 'line',
            'color' => '#d1d5db',
            'width' => '50%',
            'spacing' => '2rem',
        ];
    }

    public static function getPreview(array $data): string
    {
        return match ($data['style'] ?? 'line') {
            'dots' => '● ● ●',
            'stars' => '★ ★ ★',
            'diamond' => '◆',
            'wave' => '〰️ Wave',
            'fade' => '— Fade —',
            default => '── Line ──',
        };
    }
}
