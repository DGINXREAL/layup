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
            TextInput::make('icon')
                ->label('Icon Name')
                ->placeholder('e.g. heroicon-o-star')
                ->visible(fn (callable $get) => $get('media_type') === 'icon'),
            FileUpload::make('image')
                ->label('Image')
                ->image()
                ->directory('layup/blurbs')
                ->visible(fn (callable $get) => $get('media_type') === 'image'),
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
