<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class LogoGridWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'logo-grid';
    }

    public static function getLabel(): string
    {
        return 'Logo Grid';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-building-office-2';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->placeholder('Trusted by leading companies')
                ->nullable(),
            FileUpload::make('logos')
                ->label('Logos')
                ->image()
                ->multiple()
                ->reorderable()
                ->directory('layup/logos')
                ->columnSpanFull(),
            Select::make('columns')
                ->label('Columns')
                ->options(['3' => '3', '4' => '4', '5' => '5', '6' => '6'])
                ->default('4'),
            Select::make('max_height')
                ->label('Logo Max Height')
                ->options([
                    '2rem' => 'Small',
                    '3rem' => 'Medium',
                    '4rem' => 'Large',
                    '5rem' => 'Extra Large',
                ])
                ->default('3rem'),
            Toggle::make('grayscale')
                ->label('Grayscale (color on hover)')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => '',
            'logos' => [],
            'columns' => '4',
            'max_height' => '3rem',
            'grayscale' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['logos'] ?? []);

        return "🏢 Logo Grid ({$count} logos)";
    }
}
