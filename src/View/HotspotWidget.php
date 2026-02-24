<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class HotspotWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'hotspot';
    }

    public static function getLabel(): string
    {
        return 'Hotspot Image';
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
            FileUpload::make('image')->label('Background Image')->image()->directory('layup/hotspots')->required(),
            Repeater::make('points')
                ->label('Hotspot Points')
                ->schema([
                    TextInput::make('x')->label('X Position (%)')->numeric()->minValue(0)->maxValue(100)->required(),
                    TextInput::make('y')->label('Y Position (%)')->numeric()->minValue(0)->maxValue(100)->required(),
                    TextInput::make('label')->label('Label')->required(),
                    TextInput::make('description')->label('Description')->nullable(),
                ])
                ->defaultItems(1)
                ->columnSpanFull(),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['image' => '', 'points' => []];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['points'] ?? []);

        return "📍 Hotspot Image ({$count} points)";
    }
}
