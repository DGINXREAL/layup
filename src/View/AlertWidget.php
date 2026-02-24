<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class AlertWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'alert';
    }

    public static function getLabel(): string
    {
        return 'Alert';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-exclamation-triangle';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Select::make('type')
                ->label('Type')
                ->options([
                    'info' => 'Info',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'danger' => 'Danger',
                ])
                ->default('info'),
            TextInput::make('title')
                ->label('Title')
                ->nullable(),
            RichEditor::make('content')
                ->label('Content')
                ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                ->columnSpanFull(),
            Toggle::make('dismissible')
                ->label('Dismissible')
                ->default(false),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'type' => 'info',
            'title' => '',
            'content' => '',
            'dismissible' => false,
        ];
    }

    public static function getPreview(array $data): string
    {
        $type = strtoupper($data['type'] ?? 'info');
        $title = $data['title'] ?? '';

        return "⚠️ [{$type}] {$title}";
    }
}
