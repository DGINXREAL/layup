<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class SocialFollowWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'social-follow';
    }

    public static function getLabel(): string
    {
        return 'Social Follow';
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
            Repeater::make('links')
                ->label('Social Links')
                ->schema([
                    Select::make('network')
                        ->label('Network')
                        ->options([
                            'facebook' => 'Facebook',
                            'twitter' => 'X / Twitter',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn',
                            'youtube' => 'YouTube',
                            'tiktok' => 'TikTok',
                            'pinterest' => 'Pinterest',
                            'github' => 'GitHub',
                            'dribbble' => 'Dribbble',
                            'email' => 'Email',
                        ])
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->required(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('style')
                ->label('Style')
                ->options([
                    'icon' => 'Icon Only',
                    'icon-text' => 'Icon + Text',
                    'text' => 'Text Only',
                ])
                ->default('icon'),
            Toggle::make('new_tab')
                ->label('Open in new tab')
                ->default(true),
            Select::make('icon_size')
                ->label('Icon Size')
                ->options([
                    'sm' => 'Small',
                    'md' => 'Medium',
                    'lg' => 'Large',
                ])
                ->default('md'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'links' => [],
            'style' => 'icon',
            'new_tab' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['links'] ?? []);

        return "🔗 Social · {$count} links";
    }
}
