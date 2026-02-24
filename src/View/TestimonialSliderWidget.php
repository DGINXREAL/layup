<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class TestimonialSliderWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'testimonial-slider';
    }

    public static function getLabel(): string
    {
        return 'Testimonial Slider';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-chat-bubble-bottom-center-text';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('testimonials')
                ->label('Testimonials')
                ->schema([
                    Textarea::make('quote')
                        ->label('Quote')
                        ->required()
                        ->rows(3),
                    TextInput::make('name')
                        ->label('Name')
                        ->required(),
                    TextInput::make('title')
                        ->label('Title / Company')
                        ->nullable(),
                    FileUpload::make('avatar')
                        ->label('Avatar')
                        ->image()
                        ->avatar()
                        ->directory('layup/testimonials'),
                    TextInput::make('rating')
                        ->label('Rating (1-5)')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(5)
                        ->nullable(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('autoplay_speed')
                ->label('Autoplay Speed')
                ->options([
                    '0' => 'No Autoplay',
                    '3000' => '3 seconds',
                    '5000' => '5 seconds',
                    '8000' => '8 seconds',
                ])
                ->default('5000'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'testimonials' => [],
            'autoplay_speed' => '5000',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['testimonials'] ?? []);

        return "💬 Testimonial Slider ({$count})";
    }
}
