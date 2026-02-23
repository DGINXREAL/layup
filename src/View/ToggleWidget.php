<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ToggleWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'toggle';
    }

    public static function getLabel(): string
    {
        return 'Toggle';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-chevron-down';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->required(),
            RichEditor::make('content')
                ->label('Content')
                ->columnSpanFull(),
            Toggle::make('open')
                ->label('Open by default')
                ->default(false),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => '',
            'content' => '',
            'open' => false,
        ];
    }

    public static function getPreview(array $data): string
    {
        $title = $data['title'] ?? '';

        return $title ? "▸ {$title}" : '(empty toggle)';
    }
}
