<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class CookieConsentWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'cookie-consent';
    }

    public static function getLabel(): string
    {
        return 'Cookie Consent';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-shield-check';
    }

    public static function getCategory(): string
    {
        return 'interactive';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('message')
                ->label('Message')
                ->default('We use cookies to enhance your experience. By continuing, you agree to our use of cookies.')
                ->required()
                ->columnSpanFull(),
            TextInput::make('accept_text')
                ->label('Accept Button Text')
                ->default('Accept'),
            TextInput::make('decline_text')
                ->label('Decline Button Text')
                ->default('Decline'),
            TextInput::make('policy_url')
                ->label('Privacy Policy URL')
                ->url()
                ->nullable(),
            TextInput::make('policy_text')
                ->label('Policy Link Text')
                ->default('Privacy Policy'),
            TextInput::make('bg_color')
                ->label('Background Color')
                ->type('color')
                ->default('#1f2937'),
            Select::make('position')
                ->label('Position')
                ->options([
                    'bottom' => 'Bottom',
                    'top' => 'Top',
                ])
                ->default('bottom'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'message' => 'We use cookies to enhance your experience. By continuing, you agree to our use of cookies.',
            'accept_text' => 'Accept',
            'decline_text' => 'Decline',
            'policy_url' => '',
            'policy_text' => 'Privacy Policy',
            'bg_color' => '#1f2937',
            'position' => 'bottom',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🍪 Cookie Consent Banner';
    }
}
