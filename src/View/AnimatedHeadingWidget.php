<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class AnimatedHeadingWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'animated-heading';
    }

    public static function getLabel(): string
    {
        return 'Animated Heading';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-sparkles';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('before_text')
                ->label('Before Text')
                ->nullable(),
            TextInput::make('animated_text')
                ->label('Animated Text')
                ->required(),
            TextInput::make('after_text')
                ->label('After Text')
                ->nullable(),
            Select::make('tag')
                ->label('Tag')
                ->options(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'])
                ->default('h2'),
            Select::make('effect')
                ->label('Effect')
                ->options([
                    'highlight' => 'Highlight',
                    'underline' => 'Underline',
                    'circle' => 'Circle',
                    'strikethrough' => 'Strikethrough',
                ])
                ->default('highlight'),
            TextInput::make('accent_color')
                ->label('Accent Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'before_text' => '',
            'animated_text' => '',
            'after_text' => '',
            'tag' => 'h2',
            'effect' => 'highlight',
            'accent_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '✨ ' . ($data['before_text'] ?? '') . ' [' . ($data['animated_text'] ?? '') . '] ' . ($data['after_text'] ?? '');
    }
}
