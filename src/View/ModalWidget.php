<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ModalWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'modal';
    }

    public static function getLabel(): string
    {
        return 'Modal / Popup';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-window';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('trigger_text')
                ->label('Trigger Button Text')
                ->default('Open')
                ->required(),
            TextInput::make('title')
                ->label('Modal Title')
                ->nullable(),
            RichEditor::make('body')
                ->label('Modal Content')
                ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList'])
                ->columnSpanFull(),
            Select::make('size')
                ->label('Size')
                ->options([
                    'sm' => 'Small (400px)',
                    'md' => 'Medium (600px)',
                    'lg' => 'Large (800px)',
                    'xl' => 'Extra Large (1000px)',
                ])
                ->default('md'),
            TextInput::make('trigger_bg_color')
                ->label('Trigger Button Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'trigger_text' => 'Open',
            'title' => '',
            'body' => '',
            'size' => 'md',
            'trigger_bg_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🪟 Modal: ' . ($data['trigger_text'] ?? 'Open');
    }
}
