<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class NotificationBarWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'notification-bar';
    }

    public static function getLabel(): string
    {
        return 'Notification Bar';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-bell-alert';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('text')
                ->label('Message')
                ->required()
                ->columnSpanFull(),
            TextInput::make('link_text')
                ->label('Link Text')
                ->placeholder('Learn more →')
                ->nullable(),
            TextInput::make('link_url')
                ->label('Link URL')
                ->url()
                ->nullable(),
            TextInput::make('bg_color')
                ->label('Background Color')
                ->type('color')
                ->default('#3b82f6'),
            TextInput::make('text_color_bar')
                ->label('Text Color')
                ->type('color')
                ->default('#ffffff'),
            Toggle::make('dismissible')
                ->label('Dismissible')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'text' => '',
            'link_text' => '',
            'link_url' => '',
            'bg_color' => '#3b82f6',
            'text_color_bar' => '#ffffff',
            'dismissible' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $text = $data['text'] ?? '';

        return "🔔 {$text}";
    }
}
