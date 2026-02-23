<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class SliderWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'slider';
    }

    public static function getLabel(): string
    {
        return 'Slider';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-presentation-chart-bar';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('slides')
                ->label('Slides')
                ->schema([
                    TextInput::make('heading')
                        ->label('Heading')
                        ->nullable(),
                    RichEditor::make('content')
                        ->label('Content')
                        ->columnSpanFull(),
                    FileUpload::make('image')
                        ->label('Background Image')
                        ->image()
                        ->directory('layup/slider'),
                    TextInput::make('button_text')
                        ->label('Button Text')
                        ->nullable(),
                    TextInput::make('button_url')
                        ->label('Button URL')
                        ->url()
                        ->nullable(),
                ])
                ->defaultItems(2)
                ->collapsible()
                ->columnSpanFull(),
            Toggle::make('autoplay')
                ->label('Autoplay')
                ->default(true),
            Select::make('speed')
                ->label('Slide Duration')
                ->options([
                    '3000' => '3 seconds',
                    '5000' => '5 seconds',
                    '7000' => '7 seconds',
                    '10000' => '10 seconds',
                ])
                ->default('5000'),
            Toggle::make('arrows')
                ->label('Show Arrows')
                ->default(true),
            Toggle::make('dots')
                ->label('Show Dots')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'slides' => [
                ['heading' => '', 'content' => '', 'image' => '', 'button_text' => '', 'button_url' => ''],
                ['heading' => '', 'content' => '', 'image' => '', 'button_text' => '', 'button_url' => ''],
            ],
            'autoplay' => true,
            'speed' => '5000',
            'arrows' => true,
            'dots' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['slides'] ?? []);

        return "🎠 Slider · {$count} slides";
    }
}
