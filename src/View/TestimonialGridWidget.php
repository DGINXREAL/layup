<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TestimonialGridWidget extends BaseWidget
{
    public static function getType(): string { return 'testimonial-grid'; }
    public static function getLabel(): string { return 'Testimonial Grid'; }
    public static function getIcon(): string { return 'heroicon-o-chat-bubble-bottom-center-text'; }
    public static function getCategory(): string { return 'content'; }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('testimonials')
                ->label('Testimonials')
                ->schema([
                    TextInput::make('quote')->label('Quote')->required(),
                    TextInput::make('name')->label('Name')->required(),
                    TextInput::make('role')->label('Role')->nullable(),
                    Select::make('rating')->label('Rating')->options([
                        '3' => '★★★', '4' => '★★★★', '5' => '★★★★★',
                    ])->default('5'),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('columns')
                ->label('Columns')
                ->options(['1' => '1', '2' => '2', '3' => '3'])
                ->default('3'),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['testimonials' => [], 'columns' => '3'];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['testimonials'] ?? []);
        return "💬 Testimonial Grid ({$count})";
    }
}
