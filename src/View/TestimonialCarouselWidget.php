<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TestimonialCarouselWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'testimonial-carousel';
    }

    public static function getLabel(): string
    {
        return 'Testimonial Carousel';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-chat-bubble-left-right';
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
                    TextInput::make('quote')
                        ->label('Quote')
                        ->required(),
                    TextInput::make('author')
                        ->label('Author')
                        ->required(),
                    TextInput::make('role')
                        ->label('Role / Company')
                        ->nullable(),
                    FileUpload::make('photo')
                        ->label('Photo')
                        ->image()
                        ->avatar()
                        ->directory('layup/testimonials'),
                    Select::make('rating')
                        ->label('Rating')
                        ->options(['1' => '★', '2' => '★★', '3' => '★★★', '4' => '★★★★', '5' => '★★★★★'])
                        ->default('5'),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Toggle::make('autoplay')
                ->label('Autoplay')
                ->default(true),
            TextInput::make('speed')
                ->label('Interval (ms)')
                ->numeric()
                ->default(5000),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'testimonials' => [],
            'autoplay' => true,
            'speed' => 5000,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['testimonials'] ?? []);
        return "💬 Testimonial Carousel ({$count} slides)";
    }
}
