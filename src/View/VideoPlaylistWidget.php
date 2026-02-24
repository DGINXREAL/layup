<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class VideoPlaylistWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'video-playlist';
    }

    public static function getLabel(): string
    {
        return 'Video Playlist';
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
            Repeater::make('videos')
                ->label('Videos')
                ->schema([
                    TextInput::make('title')->label('Title')->required(),
                    TextInput::make('url')->label('YouTube/Vimeo URL')->url()->required(),
                    TextInput::make('duration')->label('Duration')->placeholder('3:45')->nullable(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('layout')
                ->label('Layout')
                ->options([
                    'list' => 'List with player',
                    'grid' => '3-Column Grid',
                ])
                ->default('list'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'videos' => [],
            'layout' => 'list',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['videos'] ?? []);

        return "🎬 Video Playlist ({$count} videos)";
    }
}
