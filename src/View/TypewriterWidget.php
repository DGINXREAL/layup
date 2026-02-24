<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TypewriterWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'typewriter';
    }

    public static function getLabel(): string
    {
        return 'Typewriter Text';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-cursor-arrow-rays';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('prefix')
                ->label('Static Prefix')
                ->placeholder('We build ')
                ->nullable(),
            Repeater::make('words')
                ->label('Rotating Words')
                ->simple(
                    TextInput::make('word')
                        ->required()
                )
                ->defaultItems(3)
                ->columnSpanFull(),
            TextInput::make('suffix')
                ->label('Static Suffix')
                ->nullable(),
            TextInput::make('speed')
                ->label('Typing Speed (ms per char)')
                ->numeric()
                ->default(100),
            TextInput::make('pause')
                ->label('Pause Between Words (ms)')
                ->numeric()
                ->default(2000),
            Toggle::make('loop')
                ->label('Loop')
                ->default(true),
            TextInput::make('cursor_color')
                ->label('Cursor Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'prefix' => '',
            'words' => ['amazing', 'beautiful', 'powerful'],
            'suffix' => '',
            'speed' => 100,
            'pause' => 2000,
            'loop' => true,
            'cursor_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        $first = is_array($data['words'] ?? null) ? ($data['words'][0] ?? '') : '';

        return "⌨️ {$data['prefix']}{$first}|";
    }
}
