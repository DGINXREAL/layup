<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class CallToActionWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'cta';
    }

    public static function getLabel(): string
    {
        return 'Call To Action';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-megaphone';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->required(),
            RichEditor::make('content')
                ->label('Body Text')
                ->columnSpanFull(),
            TextInput::make('button_text')
                ->label('Button Text')
                ->default('Learn More'),
            TextInput::make('button_url')
                ->label('Button URL')
                ->url(),
            Select::make('button_style')
                ->label('Button Style')
                ->options([
                    'primary' => 'Primary',
                    'secondary' => 'Secondary',
                    'outline' => 'Outline',
                ])
                ->default('primary'),
            Toggle::make('new_tab')
                ->label('Open in new tab')
                ->default(false),
            TextInput::make('bg_color')
                ->label('Background Color')
                ->type('color')
                ->nullable(),
            TextInput::make('text_color_cta')
                ->label('Text Color')
                ->type('color')
                ->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => '',
            'content' => '',
            'button_text' => 'Learn More',
            'button_url' => '#',
        ];
    }

    public static function getPreview(array $data): string
    {
        $title = $data['title'] ?? '';

        return $title ? "📢 {$title}" : '(empty CTA)';
    }
}
