<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class MapWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'map';
    }

    public static function getLabel(): string
    {
        return 'Map';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-map-pin';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('address')
                ->label('Address')
                ->helperText('Enter an address or place name')
                ->nullable(),
            Textarea::make('embed')
                ->label('Embed Code')
                ->helperText('Paste a Google Maps or other embed iframe. Overrides address if set.')
                ->rows(4)
                ->nullable()
                ->columnSpanFull(),
            Select::make('height')
                ->label('Height')
                ->options([
                    '200px' => 'Small (200px)',
                    '300px' => 'Medium (300px)',
                    '400px' => 'Large (400px)',
                    '500px' => 'Extra Large (500px)',
                ])
                ->default('300px'),
            Select::make('zoom')
                ->label('Zoom Level')
                ->options([
                    '10' => 'City',
                    '13' => 'Neighborhood',
                    '15' => 'Street',
                    '18' => 'Building',
                ])
                ->default('13'),
            Select::make('map_type')
                ->label('Map Type')
                ->options([
                    'roadmap' => 'Roadmap',
                    'satellite' => 'Satellite',
                    'terrain' => 'Terrain',
                    'hybrid' => 'Hybrid',
                ])
                ->default('roadmap'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'address' => '',
            'embed' => '',
            'height' => '300px',
            'zoom' => '13',
        ];
    }

    public static function getPreview(array $data): string
    {
        $address = $data['address'] ?? '';

        return $address ? "📍 {$address}" : '📍 (no address)';
    }
}
