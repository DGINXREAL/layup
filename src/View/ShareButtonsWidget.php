<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class ShareButtonsWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'share-buttons';
    }

    public static function getLabel(): string
    {
        return 'Share Buttons';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-share';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            CheckboxList::make('networks')
                ->label('Networks')
                ->options([
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter / X',
                    'linkedin' => 'LinkedIn',
                    'reddit' => 'Reddit',
                    'email' => 'Email',
                    'copy' => 'Copy Link',
                ])
                ->default(['facebook', 'twitter', 'linkedin', 'email'])
                ->columns(2),
            Select::make('style')
                ->label('Style')
                ->options([
                    'icon' => 'Icon Only',
                    'label' => 'Icon + Label',
                    'text' => 'Text Only',
                ])
                ->default('icon'),
            Select::make('layout')
                ->label('Layout')
                ->options([
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ])
                ->default('horizontal'),
            Toggle::make('new_tab')
                ->label('Open in New Tab')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'networks' => ['facebook', 'twitter', 'linkedin', 'email'],
            'style' => 'icon',
            'layout' => 'horizontal',
            'new_tab' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['networks'] ?? []);
        return "🔗 Share Buttons ({$count} networks)";
    }
}
