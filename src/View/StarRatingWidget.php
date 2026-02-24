<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class StarRatingWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'star-rating';
    }

    public static function getLabel(): string
    {
        return 'Star Rating';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-star';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Select::make('rating')
                ->label('Rating')
                ->options([
                    '0.5' => '½', '1' => '1', '1.5' => '1½', '2' => '2', '2.5' => '2½',
                    '3' => '3', '3.5' => '3½', '4' => '4', '4.5' => '4½', '5' => '5',
                ])
                ->default('5')
                ->required(),
            Select::make('max')
                ->label('Max Stars')
                ->options(['5' => '5', '10' => '10'])
                ->default('5'),
            TextInput::make('label')
                ->label('Label')
                ->placeholder('e.g. 4.8 out of 5')
                ->nullable(),
            Select::make('size')
                ->label('Size')
                ->options(['sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large'])
                ->default('md'),
            TextInput::make('color')
                ->label('Star Color')
                ->type('color')
                ->default('#facc15'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'rating' => '5',
            'max' => '5',
            'label' => '',
            'size' => 'md',
            'color' => '#facc15',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '⭐ ' . ($data['rating'] ?? 5) . '/' . ($data['max'] ?? 5);
    }
}
