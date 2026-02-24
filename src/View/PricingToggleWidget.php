<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PricingToggleWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'pricing-toggle';
    }

    public static function getLabel(): string
    {
        return 'Pricing Toggle';
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
            TextInput::make('monthly_label')
                ->label('Monthly Label')
                ->default('Monthly'),
            TextInput::make('annual_label')
                ->label('Annual Label')
                ->default('Annual'),
            TextInput::make('discount_badge')
                ->label('Discount Badge')
                ->placeholder('Save 20%')
                ->nullable(),
            Repeater::make('plans')
                ->label('Plans')
                ->schema([
                    TextInput::make('name')
                        ->label('Plan Name')
                        ->required(),
                    TextInput::make('monthly_price')
                        ->label('Monthly Price')
                        ->required(),
                    TextInput::make('annual_price')
                        ->label('Annual Price')
                        ->required(),
                    TextInput::make('features')
                        ->label('Features (comma-separated)')
                        ->nullable(),
                    TextInput::make('cta_text')
                        ->label('CTA Text')
                        ->default('Get Started'),
                    TextInput::make('cta_url')
                        ->label('CTA URL')
                        ->url()
                        ->nullable(),
                    Toggle::make('featured')
                        ->label('Featured / Popular')
                        ->default(false),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            TextInput::make('accent_color')
                ->label('Accent Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'monthly_label' => 'Monthly',
            'annual_label' => 'Annual',
            'discount_badge' => 'Save 20%',
            'plans' => [],
            'accent_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['plans'] ?? []);

        return "💰 Pricing Toggle ({$count} plans)";
    }
}
