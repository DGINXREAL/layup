<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ContactFormWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'contact-form';
    }

    public static function getLabel(): string
    {
        return 'Contact Form';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-envelope';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('action')
                ->label('Form Action URL')
                ->helperText('Where the form submits (e.g. /contact, Formspree URL, mailto:)')
                ->required(),
            TextInput::make('submit_text')
                ->label('Submit Button Text')
                ->default('Send Message'),
            TextInput::make('success_message')
                ->label('Success Message')
                ->default('Thank you! Your message has been sent.'),
            Repeater::make('fields')
                ->label('Form Fields')
                ->schema([
                    TextInput::make('label')
                        ->label('Label')
                        ->required(),
                    TextInput::make('name')
                        ->label('Field Name')
                        ->required(),
                    Select::make('type')
                        ->label('Type')
                        ->options([
                            'text' => 'Text',
                            'email' => 'Email',
                            'tel' => 'Phone',
                            'textarea' => 'Text Area',
                            'select' => 'Dropdown',
                        ])
                        ->default('text')
                        ->required(),
                    Toggle::make('required')
                        ->label('Required')
                        ->default(false),
                    TextInput::make('placeholder')
                        ->label('Placeholder')
                        ->nullable(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'action' => '/contact',
            'submit_text' => 'Send Message',
            'success_message' => 'Thank you! Your message has been sent.',
            'fields' => [
                ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'required' => true, 'placeholder' => 'Your name'],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'required' => true, 'placeholder' => 'your@email.com'],
                ['label' => 'Message', 'name' => 'message', 'type' => 'textarea', 'required' => true, 'placeholder' => 'How can we help?'],
            ],
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['fields'] ?? []);

        return "📧 Contact Form ({$count} fields)";
    }
}
