<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class ImageHotspotWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'image-hotspot';
    }

    public static function getLabel(): string
    {
        return 'Image Hotspot';
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
            FileUpload::make('image')
                ->label('Image')
                ->image()
                ->directory('layup/hotspots')
                ->required(),
            Repeater::make('hotspots')
                ->label('Hotspots')
                ->schema([
                    TextInput::make('x')
                        ->label('X Position (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required(),
                    TextInput::make('y')
                        ->label('Y Position (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required(),
                    TextInput::make('title')
                        ->label('Title')
                        ->required(),
                    TextInput::make('description')
                        ->label('Description')
                        ->nullable(),
                    TextInput::make('link_url')
                        ->label('Link URL')
                        ->url()
                        ->nullable(),
                ])
                ->defaultItems(0)
                ->columnSpanFull(),
            TextInput::make('pin_color')
                ->label('Pin Color')
                ->type('color')
                ->default('#ef4444'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'image' => '',
            'hotspots' => [],
            'pin_color' => '#ef4444',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['hotspots'] ?? []);

        return "📍 Image Hotspot ({$count} pins)";
    }
}
