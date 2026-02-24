<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TableOfContentsWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'table-of-contents';
    }

    public static function getLabel(): string
    {
        return 'Table of Contents';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-list-bullet';
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
                ->default('Table of Contents'),
            Select::make('heading_levels')
                ->label('Heading Levels to Include')
                ->multiple()
                ->options(['h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'])
                ->default(['h2', 'h3']),
            Toggle::make('numbered')
                ->label('Numbered List')
                ->default(true),
            Toggle::make('collapsible')
                ->label('Collapsible')
                ->default(false),
            Toggle::make('sticky')
                ->label('Sticky Position')
                ->default(false),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => 'Table of Contents',
            'heading_levels' => ['h2', 'h3'],
            'numbered' => true,
            'collapsible' => false,
            'sticky' => false,
        ];
    }

    public static function getPreview(array $data): string
    {
        return '📑 Table of Contents';
    }
}
