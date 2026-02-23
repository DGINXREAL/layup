<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class AudioWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'audio';
    }

    public static function getLabel(): string
    {
        return 'Audio';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-musical-note';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Title')
                ->nullable(),
            TextInput::make('artist')
                ->label('Artist')
                ->nullable(),
            FileUpload::make('file')
                ->label('Audio File')
                ->acceptedFileTypes(['audio/*'])
                ->directory('layup/audio'),
            TextInput::make('url')
                ->label('Or Audio URL')
                ->url()
                ->nullable()
                ->helperText('Direct link to an audio file. Used if no file is uploaded.'),
            FileUpload::make('cover')
                ->label('Cover Art')
                ->image()
                ->directory('layup/audio'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => '',
            'artist' => '',
            'file' => '',
            'url' => '',
            'cover' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        $title = $data['title'] ?? '';
        $artist = $data['artist'] ?? '';

        if ($title) {
            return "🎵 {$title}" . ($artist ? " — {$artist}" : '');
        }

        return '🎵 (no audio)';
    }
}
