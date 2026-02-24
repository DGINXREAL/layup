<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BlockquoteWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'blockquote';
    }

    public static function getLabel(): string
    {
        return 'Blockquote';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-chat-bubble-left';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Textarea::make('quote')
                ->label('Quote Text')
                ->required()
                ->rows(4)
                ->columnSpanFull(),
            TextInput::make('attribution')
                ->label('Attribution')
                ->placeholder('— Author Name')
                ->nullable(),
            TextInput::make('source')
                ->label('Source')
                ->placeholder('Book, article, speech...')
                ->nullable(),
            Select::make('style')
                ->label('Style')
                ->options([
                    'border-left' => 'Left Border',
                    'large' => 'Large Quote',
                    'centered' => 'Centered',
                ])
                ->default('border-left'),
            TextInput::make('accent_color')
                ->label('Accent Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'quote' => '',
            'attribution' => '',
            'source' => '',
            'style' => 'border-left',
            'accent_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        $quote = $data['quote'] ?? '';
        $short = mb_strlen($quote) > 50 ? mb_substr($quote, 0, 50) . '…' : $quote;

        return "❝ {$short}";
    }
}
