<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class CardWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'card';
    }

    public static function getLabel(): string
    {
        return 'Card';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-rectangle-stack';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('image')
                ->label('Image')
                ->image()
                ->directory('layup/cards'),
            TextInput::make('title')
                ->label('Title')
                ->required(),
            RichEditor::make('body')
                ->label('Body')
                ->toolbarButtons(['bold', 'italic', 'link'])
                ->columnSpanFull(),
            TextInput::make('link_url')
                ->label('Link URL')
                ->url()
                ->nullable(),
            TextInput::make('link_text')
                ->label('Link Text')
                ->default('Learn more')
                ->nullable(),
            Toggle::make('shadow')
                ->label('Drop Shadow')
                ->default(true),
            Toggle::make('hover_lift')
                ->label('Hover Lift Effect')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'image' => '',
            'title' => '',
            'body' => '',
            'link_url' => '',
            'link_text' => 'Learn more',
            'shadow' => true,
            'hover_lift' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🃏 ' . ($data['title'] ?? '(empty card)');
    }
}
