<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PricingTableWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'pricing-table';
    }

    public static function getLabel(): string
    {
        return 'Pricing Table';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-currency-dollar';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Plan Name')
                ->required(),
            TextInput::make('subtitle')
                ->label('Subtitle')
                ->nullable(),
            TextInput::make('price')
                ->label('Price')
                ->required()
                ->placeholder('49'),
            TextInput::make('currency')
                ->label('Currency Symbol')
                ->default('$'),
            Select::make('period')
                ->label('Billing Period')
                ->options([
                    'month' => 'Per Month',
                    'year' => 'Per Year',
                    'once' => 'One-Time',
                    'custom' => 'Custom',
                ])
                ->default('month'),
            TextInput::make('period_custom')
                ->label('Custom Period Text')
                ->visible(fn (callable $get) => $get('period') === 'custom')
                ->nullable(),
            Repeater::make('features')
                ->label('Features')
                ->schema([
                    TextInput::make('text')
                        ->label('Feature')
                        ->required(),
                    Toggle::make('included')
                        ->label('Included')
                        ->default(true),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            TextInput::make('button_text')
                ->label('Button Text')
                ->default('Get Started'),
            TextInput::make('button_url')
                ->label('Button URL')
                ->url(),
            Toggle::make('featured')
                ->label('Featured / Highlighted')
                ->default(false),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'title' => '',
            'subtitle' => '',
            'price' => '',
            'currency' => '$',
            'period' => 'month',
            'period_custom' => '',
            'features' => [],
            'button_text' => 'Get Started',
            'button_url' => '#',
            'featured' => false,
        ];
    }

    public static function getPreview(array $data): string
    {
        $title = $data['title'] ?? '';
        $price = ($data['currency'] ?? '$') . ($data['price'] ?? '');

        return $title ? "💰 {$title} · {$price}" : '(empty pricing table)';
    }
}
