<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FlipCardWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'flip-card';
    }

    public static function getLabel(): string
    {
        return 'Flip Card';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-arrows-up-down';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('front_title')
                ->label('Front Title')
                ->required(),
            TextInput::make('front_description')
                ->label('Front Description')
                ->nullable(),
            TextInput::make('front_bg')
                ->label('Front Background')
                ->type('color')
                ->default('#3b82f6'),
            TextInput::make('back_title')
                ->label('Back Title')
                ->required(),
            TextInput::make('back_description')
                ->label('Back Description')
                ->nullable(),
            TextInput::make('back_bg')
                ->label('Back Background')
                ->type('color')
                ->default('#1e40af'),
            TextInput::make('link_url')
                ->label('Link URL (back)')
                ->url()
                ->nullable(),
            TextInput::make('link_text')
                ->label('Link Text')
                ->default('Learn more'),
            Select::make('direction')
                ->label('Flip Direction')
                ->options(['horizontal' => 'Horizontal', 'vertical' => 'Vertical'])
                ->default('horizontal'),
            Select::make('height')
                ->label('Card Height')
                ->options([
                    '200px' => 'Small',
                    '300px' => 'Medium',
                    '400px' => 'Large',
                ])
                ->default('300px'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'front_title' => '',
            'front_description' => '',
            'front_bg' => '#3b82f6',
            'back_title' => '',
            'back_description' => '',
            'back_bg' => '#1e40af',
            'link_url' => '',
            'link_text' => 'Learn more',
            'direction' => 'horizontal',
            'height' => '300px',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🔄 ' . ($data['front_title'] ?? '') . ' ↔ ' . ($data['back_title'] ?? '');
    }
}
