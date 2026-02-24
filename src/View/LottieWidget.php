<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class LottieWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'lottie';
    }

    public static function getLabel(): string
    {
        return 'Lottie Animation';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-play';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('src')
                ->label('Lottie JSON URL')
                ->url()
                ->helperText('URL to a .json Lottie file (from LottieFiles, etc.)')
                ->required()
                ->columnSpanFull(),
            Toggle::make('autoplay')
                ->label('Autoplay')
                ->default(true),
            Toggle::make('loop')
                ->label('Loop')
                ->default(true),
            Select::make('width')
                ->label('Width')
                ->options([
                    '100px' => 'Tiny',
                    '200px' => 'Small',
                    '300px' => 'Medium',
                    '400px' => 'Large',
                    '100%' => 'Full Width',
                ])
                ->default('300px'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'src' => '',
            'autoplay' => true,
            'loop' => true,
            'width' => '300px',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🎬 Lottie Animation';
    }
}
