<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class LogoSliderWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'logo-slider';
    }

    public static function getLabel(): string
    {
        return 'Logo Slider';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-building-office';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('logos')
                ->label('Logos')
                ->image()
                ->multiple()
                ->reorderable()
                ->directory('layup/logo-slider')
                ->columnSpanFull(),
            Select::make('speed')
                ->label('Speed')
                ->options(['40' => 'Slow', '25' => 'Normal', '15' => 'Fast'])
                ->default('25'),
            TextInput::make('max_height')
                ->label('Logo Max Height')
                ->default('3rem'),
            TextInput::make('gap')
                ->label('Gap Between Logos')
                ->default('4rem'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'logos' => [],
            'speed' => '25',
            'max_height' => '3rem',
            'gap' => '4rem',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['logos'] ?? []);
        return "🏢 Logo Slider ({$count} logos)";
    }
}
