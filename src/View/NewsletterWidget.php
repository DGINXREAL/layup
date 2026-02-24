<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class NewsletterWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'newsletter';
    }

    public static function getLabel(): string
    {
        return 'Newsletter Signup';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-envelope-open';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('heading')
                ->label('Heading')
                ->default('Stay in the loop'),
            TextInput::make('description')
                ->label('Description')
                ->default('Get the latest updates delivered to your inbox.')
                ->nullable(),
            TextInput::make('action')
                ->label('Form Action URL')
                ->helperText('Mailchimp, ConvertKit, or custom endpoint')
                ->required(),
            TextInput::make('placeholder')
                ->label('Email Placeholder')
                ->default('Enter your email'),
            TextInput::make('submit_text')
                ->label('Button Text')
                ->default('Subscribe'),
            TextInput::make('success_message')
                ->label('Success Message')
                ->default("You're in! Check your inbox."),
            Select::make('layout')
                ->label('Layout')
                ->options([
                    'inline' => 'Inline (side by side)',
                    'stacked' => 'Stacked',
                ])
                ->default('inline'),
            TextInput::make('button_color')
                ->label('Button Color')
                ->type('color')
                ->default('#3b82f6'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'heading' => 'Stay in the loop',
            'description' => 'Get the latest updates delivered to your inbox.',
            'action' => '',
            'placeholder' => 'Enter your email',
            'submit_text' => 'Subscribe',
            'success_message' => "You're in! Check your inbox.",
            'layout' => 'inline',
            'button_color' => '#3b82f6',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '📬 Newsletter Signup';
    }
}
