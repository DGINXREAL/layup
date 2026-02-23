<?php

namespace Crumbls\Layup\Widgets;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class DividerWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'divider';
    }

    public static function getLabel(): string
    {
        return 'Divider';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-minus';
    }

    public static function getCategory(): string
    {
        return 'layout';
    }

    public static function getFormSchema(): array
    {
        return [
            Select::make('style')
                ->label('Style')
                ->options([
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'double' => 'Double',
                ])
                ->default('solid'),
            Select::make('weight')
                ->label('Weight')
                ->options([
                    '1px' => 'Thin (1px)',
                    '2px' => 'Medium (2px)',
                    '3px' => 'Thick (3px)',
                    '4px' => 'Heavy (4px)',
                ])
                ->default('1px'),
            TextInput::make('color')
                ->label('Color')
                ->default('#e5e7eb')
                ->type('color'),
            Select::make('width')
                ->label('Width')
                ->options([
                    '100%' => 'Full',
                    '75%' => '75%',
                    '50%' => '50%',
                    '25%' => '25%',
                ])
                ->default('100%'),
            Select::make('spacing')
                ->label('Vertical Spacing')
                ->options([
                    '0.5rem' => 'Compact',
                    '1rem' => 'Normal',
                    '1.5rem' => 'Relaxed',
                    '2rem' => 'Spacious',
                ])
                ->default('1rem'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'style' => 'solid',
            'weight' => '1px',
            'color' => '#e5e7eb',
            'width' => '100%',
            'spacing' => '1rem',
        ];
    }

    public static function getPreview(array $data): string
    {
        $style = $data['style'] ?? 'solid';
        $width = $data['width'] ?? '100%';
        return "— Divider · {$style} · {$width}";
    }
}
