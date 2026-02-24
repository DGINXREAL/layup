<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class SearchWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'search';
    }

    public static function getLabel(): string
    {
        return 'Search';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-magnifying-glass';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('placeholder')
                ->label('Placeholder Text')
                ->default('Search...')
                ->nullable(),
            TextInput::make('action')
                ->label('Form Action URL')
                ->helperText('Where the search form submits to')
                ->default('/search')
                ->nullable(),
            TextInput::make('param')
                ->label('Query Parameter')
                ->default('q')
                ->nullable(),
            Select::make('size')
                ->label('Size')
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
            'placeholder' => 'Search...',
            'action' => '/search',
            'param' => 'q',
            'size' => 'md',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🔍 Search form';
    }
}
