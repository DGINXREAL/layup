<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ContentToggleWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'content-toggle';
    }

    public static function getLabel(): string
    {
        return 'Content Toggle';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-eye-slash';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('show_text')
                ->label('Show Button Text')
                ->default('Show more'),
            TextInput::make('hide_text')
                ->label('Hide Button Text')
                ->default('Show less'),
            RichEditor::make('content')
                ->label('Hidden Content')
                ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList'])
                ->columnSpanFull(),
            Toggle::make('start_open')
                ->label('Start Expanded')
                ->default(false),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'show_text' => 'Show more',
            'hide_text' => 'Show less',
            'content' => '',
            'start_open' => false,
        ];
    }

    public static function getPreview(array $data): string
    {
        return '👁 Content Toggle';
    }
}
