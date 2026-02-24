<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class GradientTextWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'gradient-text';
    }

    public static function getLabel(): string
    {
        return 'Gradient Text';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-paint-brush';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('text')
                ->label('Text')
                ->required()
                ->columnSpanFull(),
            Select::make('tag')
                ->label('HTML Tag')
                ->options(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'p' => 'Paragraph', 'span' => 'Span'])
                ->default('h2'),
            TextInput::make('from_color')
                ->label('From Color')
                ->type('color')
                ->default('#667eea'),
            TextInput::make('to_color')
                ->label('To Color')
                ->type('color')
                ->default('#764ba2'),
            TextInput::make('via_color')
                ->label('Via Color (optional)')
                ->type('color')
                ->nullable(),
            Select::make('direction')
                ->label('Direction')
                ->options([
                    'to right' => 'Left → Right',
                    'to left' => 'Right → Left',
                    'to bottom' => 'Top → Bottom',
                    'to bottom right' => 'Diagonal ↘',
                    '135deg' => 'Diagonal ↗',
                ])
                ->default('to right'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'text' => '',
            'tag' => 'h2',
            'from_color' => '#667eea',
            'to_color' => '#764ba2',
            'via_color' => '',
            'direction' => 'to right',
        ];
    }

    public static function getPreview(array $data): string
    {
        $text = $data['text'] ?? '';
        return "🌈 {$text}";
    }
}
