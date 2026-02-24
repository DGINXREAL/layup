<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Crumbls\Layup\Support\WidgetContext;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class VideoWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'video';
    }

    public static function getLabel(): string
    {
        return 'Video Embed';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-play-circle';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('url')
                ->label('Video URL')
                ->helperText('YouTube, Vimeo, or direct video URL')
                ->required()
                ->url(),
            Select::make('aspect')
                ->label('Aspect Ratio')
                ->options([
                    '16/9' => '16:9 (Widescreen)',
                    '4/3' => '4:3 (Standard)',
                    '1/1' => '1:1 (Square)',
                    '21/9' => '21:9 (Ultra-wide)',
                ])
                ->default('16/9'),
            TextInput::make('title')
                ->label('Title / Caption'),
            Toggle::make('autoplay')
                ->label('Autoplay')
                ->default(false),
            Toggle::make('loop')
                ->label('Loop')
                ->default(false),
            Toggle::make('privacy_enhanced')
                ->label('Privacy-enhanced mode (YouTube)')
                ->helperText('Uses youtube-nocookie.com domain')
                ->default(false),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'url' => '',
            'aspect' => '16/9',
            'title' => '',
            'autoplay' => false,
            'loop' => false,
        ];
    }

    public static function getPreview(array $data): string
    {
        $url = $data['url'] ?? '';
        if (! $url) {
            return '▶ (no video)';
        }

        if (str_contains($url, 'youtube') || str_contains($url, 'youtu.be')) {
            return '▶ YouTube · ' . $url;
        }
        if (str_contains($url, 'vimeo')) {
            return '▶ Vimeo · ' . $url;
        }

        return '▶ Video · ' . basename($url);
    }

    /**
     * Normalize YouTube URLs to embed format on save.
     */
    public static function onSave(array $data, ?WidgetContext $context = null): array
    {
        if (! empty($data['url'])) {
            $privacy = !empty($data['privacy_enhanced']);
            $data['embed_url'] = static::toEmbedUrl($data['url'], $privacy);
        }

        return $data;
    }

    protected static function toEmbedUrl(string $url, bool $privacyEnhanced = false): string
    {
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            $domain = $privacyEnhanced ? 'www.youtube-nocookie.com' : 'www.youtube.com';
            return "https://{$domain}/embed/{$m[1]}";
        }

        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $m)) {
            return "https://player.vimeo.com/video/{$m[1]}";
        }

        return $url;
    }
}
