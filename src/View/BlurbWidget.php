<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BlurbWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'blurb';
    }

    public static function getLabel(): string
    {
        return 'Blurb';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-light-bulb';
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
            Select::make('media_type')
                ->label('Media Type')
                ->options([
                    'icon' => 'Icon',
                    'image' => 'Image',
                    'none' => 'None',
                ])
                ->default('icon')
                ->reactive(),
            Select::make('icon')
                ->label('Icon')
                ->searchable()
                ->options([
                    // Arrows & Navigation
                    'heroicon-o-arrow-right' => '→ Arrow Right',
                    'heroicon-o-arrow-left' => '← Arrow Left',
                    'heroicon-o-arrow-up' => '↑ Arrow Up',
                    'heroicon-o-arrow-down' => '↓ Arrow Down',
                    'heroicon-o-chevron-right' => '› Chevron Right',
                    'heroicon-o-arrows-pointing-out' => '⤢ Expand',
                    // Actions
                    'heroicon-o-check' => '✓ Check',
                    'heroicon-o-check-circle' => '✓ Check Circle',
                    'heroicon-o-x-mark' => '✕ X Mark',
                    'heroicon-o-plus' => '+ Plus',
                    'heroicon-o-minus' => '− Minus',
                    'heroicon-o-pencil' => '✎ Pencil',
                    'heroicon-o-trash' => '🗑 Trash',
                    'heroicon-o-clipboard' => '📋 Clipboard',
                    'heroicon-o-clipboard-document-check' => '📋✓ Clipboard Check',
                    // Communication
                    'heroicon-o-envelope' => '✉ Envelope',
                    'heroicon-o-phone' => '📞 Phone',
                    'heroicon-o-chat-bubble-left-right' => '💬 Chat',
                    'heroicon-o-megaphone' => '📢 Megaphone',
                    'heroicon-o-bell' => '🔔 Bell',
                    'heroicon-o-inbox' => '📥 Inbox',
                    // Content & Media
                    'heroicon-o-document-text' => '📄 Document',
                    'heroicon-o-photo' => '🖼 Photo',
                    'heroicon-o-camera' => '📷 Camera',
                    'heroicon-o-video-camera' => '🎥 Video',
                    'heroicon-o-musical-note' => '🎵 Music',
                    'heroicon-o-microphone' => '🎤 Microphone',
                    'heroicon-o-film' => '🎬 Film',
                    'heroicon-o-book-open' => '📖 Book',
                    'heroicon-o-newspaper' => '📰 Newspaper',
                    // Business
                    'heroicon-o-briefcase' => '💼 Briefcase',
                    'heroicon-o-building-office' => '🏢 Office',
                    'heroicon-o-chart-bar' => '📊 Chart Bar',
                    'heroicon-o-chart-pie' => '🥧 Chart Pie',
                    'heroicon-o-presentation-chart-line' => '📈 Chart Line',
                    'heroicon-o-currency-dollar' => '💲 Dollar',
                    'heroicon-o-banknotes' => '💵 Banknotes',
                    'heroicon-o-credit-card' => '💳 Credit Card',
                    'heroicon-o-calculator' => '🔢 Calculator',
                    'heroicon-o-receipt-percent' => '🧾 Receipt',
                    // People & Social
                    'heroicon-o-user' => '👤 User',
                    'heroicon-o-users' => '👥 Users',
                    'heroicon-o-user-group' => '👥 User Group',
                    'heroicon-o-heart' => '❤ Heart',
                    'heroicon-o-hand-thumb-up' => '👍 Thumbs Up',
                    'heroicon-o-face-smile' => '😊 Smile',
                    'heroicon-o-gift' => '🎁 Gift',
                    'heroicon-o-trophy' => '🏆 Trophy',
                    'heroicon-o-academic-cap' => '🎓 Academic Cap',
                    // Objects
                    'heroicon-o-star' => '⭐ Star',
                    'heroicon-o-bolt' => '⚡ Bolt',
                    'heroicon-o-fire' => '🔥 Fire',
                    'heroicon-o-light-bulb' => '💡 Light Bulb',
                    'heroicon-o-sparkles' => '✨ Sparkles',
                    'heroicon-o-rocket-launch' => '🚀 Rocket',
                    'heroicon-o-puzzle-piece' => '🧩 Puzzle',
                    'heroicon-o-key' => '🔑 Key',
                    'heroicon-o-lock-closed' => '🔒 Lock',
                    'heroicon-o-lock-open' => '🔓 Unlock',
                    'heroicon-o-shield-check' => '🛡 Shield',
                    'heroicon-o-cog-6-tooth' => '⚙ Gear',
                    'heroicon-o-wrench-screwdriver' => '🔧 Tools',
                    'heroicon-o-beaker' => '🧪 Beaker',
                    'heroicon-o-flag' => '🚩 Flag',
                    'heroicon-o-tag' => '🏷 Tag',
                    // Technology
                    'heroicon-o-computer-desktop' => '🖥 Desktop',
                    'heroicon-o-device-phone-mobile' => '📱 Phone',
                    'heroicon-o-device-tablet' => '📱 Tablet',
                    'heroicon-o-globe-alt' => '🌐 Globe',
                    'heroicon-o-wifi' => '📶 WiFi',
                    'heroicon-o-cloud' => '☁ Cloud',
                    'heroicon-o-server' => '🖥 Server',
                    'heroicon-o-code-bracket' => '⟨/⟩ Code',
                    'heroicon-o-command-line' => '> Terminal',
                    'heroicon-o-cpu-chip' => '💻 CPU',
                    // Location & Travel
                    'heroicon-o-map-pin' => '📍 Map Pin',
                    'heroicon-o-map' => '🗺 Map',
                    'heroicon-o-home' => '🏠 Home',
                    'heroicon-o-truck' => '🚚 Truck',
                    'heroicon-o-paper-airplane' => '✈ Paper Airplane',
                    // Time
                    'heroicon-o-clock' => '🕐 Clock',
                    'heroicon-o-calendar' => '📅 Calendar',
                    'heroicon-o-calendar-days' => '📅 Calendar Days',
                    // UI
                    'heroicon-o-squares-2x2' => '⊞ Grid',
                    'heroicon-o-list-bullet' => '☰ List',
                    'heroicon-o-bars-3' => '☰ Menu',
                    'heroicon-o-magnifying-glass' => '🔍 Search',
                    'heroicon-o-funnel' => '🔽 Filter',
                    'heroicon-o-adjustments-horizontal' => '⚙ Adjustments',
                    'heroicon-o-eye' => '👁 Eye',
                    'heroicon-o-link' => '🔗 Link',
                    'heroicon-o-share' => '↗ Share',
                    'heroicon-o-bookmark' => '🔖 Bookmark',
                    // Status
                    'heroicon-o-information-circle' => 'ℹ Info',
                    'heroicon-o-exclamation-triangle' => '⚠ Warning',
                    'heroicon-o-exclamation-circle' => '❗ Error',
                    'heroicon-o-question-mark-circle' => '❓ Question',
                    'heroicon-o-no-symbol' => '🚫 No Symbol',
                ])
                ->placeholder('Choose an icon…')
                ->visible(fn (callable $get): bool => $get('media_type') === 'icon'),
            FileUpload::make('image')
                ->label('Image')
                ->image()
                ->directory('layup/blurbs')
                ->visible(fn (callable $get): bool => $get('media_type') === 'image'),
            Select::make('layout')
                ->label('Layout')
                ->options([
                    'top' => 'Icon/Image Top',
                    'left' => 'Icon/Image Left',
                    'right' => 'Icon/Image Right',
                ])
                ->default('top'),
            TextInput::make('url')
                ->label('Link URL')
                ->url()
                ->nullable(),
            Select::make('text_alignment')
                ->label('Text Alignment')
                ->options([
                    '' => 'Default',
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('')
                ->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => '',
            'content' => '',
            'media_type' => 'icon',
            'icon' => '',
            'image' => '',
            'layout' => 'top',
            'url' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        return $data['title'] ?? '(empty blurb)';
    }
}
