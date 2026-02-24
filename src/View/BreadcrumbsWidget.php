<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class BreadcrumbsWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'breadcrumbs';
    }

    public static function getLabel(): string
    {
        return 'Breadcrumbs';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-chevron-right';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('items')
                ->label('Breadcrumb Items')
                ->schema([
                    TextInput::make('label')
                        ->label('Label')
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->nullable(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            TextInput::make('separator')
                ->label('Separator')
                ->default('/')
                ->maxLength(3),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'items' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Products', 'url' => '/products'],
                ['label' => 'Current Page', 'url' => ''],
            ],
            'separator' => '/',
        ];
    }

    public static function getPreview(array $data): string
    {
        $labels = array_column($data['items'] ?? [], 'label');

        return implode(' > ', array_slice($labels, 0, 3));
    }
}
