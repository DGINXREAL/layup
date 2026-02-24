<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

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
            Repeater::make('items')
                ->label('FAQ Items')
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
            Select::make('style')
                ->label('Style')
                ->options([
                    'accordion' => 'Accordion (expand/collapse)',
                    'list' => 'Plain List (always visible)',
                    'cards' => 'Cards',
                ])
                ->default('accordion'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'items' => [],
            'style' => 'accordion',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['items'] ?? []);
        return "❓ FAQ ({$count} questions)";
    }
}
