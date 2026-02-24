<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class MenuWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'menu';
    }

    public static function getLabel(): string
    {
        return 'Menu';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-bars-3';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('items')
                ->label('Menu Items')
                ->schema([
                    TextInput::make('label')
                        ->label('Label')
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->required(),
                    Toggle::make('new_tab')
                        ->label('New tab')
                        ->default(false),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('orientation')
                ->label('Orientation')
                ->options([
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ])
                ->default('horizontal'),
            Select::make('style')
                ->label('Style')
                ->options([
                    'links' => 'Plain Links',
                    'pills' => 'Pills',
                    'underline' => 'Underline',
                ])
                ->default('links'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'items' => [
                ['label' => 'Home', 'url' => '/', 'new_tab' => false],
                ['label' => 'About', 'url' => '/about', 'new_tab' => false],
                ['label' => 'Contact', 'url' => '/contact', 'new_tab' => false],
            ],
            'orientation' => 'horizontal',
            'style' => 'links',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['items'] ?? []);

        return "☰ Menu ({$count} items)";
    }
}
