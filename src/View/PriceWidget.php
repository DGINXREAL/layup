<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class PriceWidget extends BaseWidget
{
    public static function getType(): string { return 'price'; }
    public static function getLabel(): string { return 'Price Display'; }
    public static function getIcon(): string { return 'heroicon-o-currency-dollar'; }
    public static function getCategory(): string { return 'content'; }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('amount')->label('Amount')->required()->placeholder('49'),
            TextInput::make('currency_symbol')->label('Currency Symbol')->default('$'),
            TextInput::make('period')->label('Period')->placeholder('/month')->nullable(),
            TextInput::make('original_amount')->label('Original Price (strikethrough)')->nullable(),
            TextInput::make('label')->label('Label')->placeholder('Starting at')->nullable(),
            Select::make('size')->label('Size')->options([
                'sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large', 'xl' => 'Extra Large',
            ])->default('lg'),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['amount' => '', 'currency_symbol' => '$', 'period' => '', 'original_amount' => '', 'label' => '', 'size' => 'lg'];
    }

    public static function getPreview(array $data): string
    {
        return ($data['currency_symbol'] ?? '$') . ($data['amount'] ?? '0') . ($data['period'] ?? '');
    }
}
