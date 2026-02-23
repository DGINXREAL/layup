<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class TestimonialWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'testimonial';
    }

    public static function getLabel(): string
    {
        return 'Testimonial';
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
            Textarea::make('quote')
                ->label('Quote')
                ->required()
                ->rows(4)
                ->columnSpanFull(),
            TextInput::make('author')
                ->label('Author Name')
                ->required(),
            TextInput::make('role')
                ->label('Role / Company')
                ->nullable(),
            FileUpload::make('photo')
                ->label('Author Photo')
                ->image()
                ->avatar()
                ->directory('layup/testimonials'),
            TextInput::make('url')
                ->label('Link URL')
                ->url()
                ->nullable(),
            Select::make('style')
                ->label('Style')
                ->options([
                    'default' => 'Default',
                    'card' => 'Card',
                    'minimal' => 'Minimal',
                    'centered' => 'Centered',
                ])
                ->default('default'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'quote' => '',
            'author' => '',
            'role' => '',
            'photo' => '',
            'url' => '',
            'style' => 'default',
        ];
    }

    public static function getPreview(array $data): string
    {
        $author = $data['author'] ?? '';
        $quote = $data['quote'] ?? '';
        $short = mb_strlen($quote) > 40 ? mb_substr($quote, 0, 40) . '…' : $quote;

        return $author ? "💬 {$author}: \"{$short}\"" : '(empty testimonial)';
    }
}
