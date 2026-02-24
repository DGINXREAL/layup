<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class FaqWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'faq';
    }

    public static function getLabel(): string
    {
        return 'FAQ';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-question-mark-circle';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Section Title')
                ->placeholder('Frequently Asked Questions')
                ->nullable(),
            Repeater::make('items')
                ->label('Questions')
                ->schema([
                    TextInput::make('question')
                        ->label('Question')
                        ->required(),
                    Textarea::make('answer')
                        ->label('Answer')
                        ->required()
                        ->rows(3),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Toggle::make('schema_markup')
                ->label('Include FAQ Schema.org Markup')
                ->helperText('Adds JSON-LD structured data for search engines')
                ->default(true),
            Toggle::make('collapsible')
                ->label('Collapsible (click to expand)')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => 'Frequently Asked Questions',
            'items' => [
                ['question' => 'What is this?', 'answer' => 'This is a sample FAQ item.'],
                ['question' => 'How does it work?', 'answer' => 'It works by displaying questions and answers.'],
                ['question' => 'Can I customize it?', 'answer' => 'Yes, you can add, remove, and reorder items.'],
            ],
            'schema_markup' => true,
            'collapsible' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['items'] ?? []);
        return "❓ FAQ ({$count} questions)";
    }
}
