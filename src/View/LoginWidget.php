<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class LoginWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'login';
    }

    public static function getLabel(): string
    {
        return 'Login Form';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-lock-closed';
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
                ->default('/login')
                ->required(),
            TextInput::make('title')
                ->label('Title')
                ->default('Sign In'),
            TextInput::make('email_label')
                ->label('Email Field Label')
                ->default('Email'),
            TextInput::make('password_label')
                ->label('Password Field Label')
                ->default('Password'),
            TextInput::make('submit_text')
                ->label('Submit Button Text')
                ->default('Sign In'),
            TextInput::make('forgot_url')
                ->label('Forgot Password URL')
                ->nullable(),
            TextInput::make('register_url')
                ->label('Register URL')
                ->nullable(),
            Toggle::make('remember_me')
                ->label('Show Remember Me')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'action' => '/login',
            'title' => 'Sign In',
            'email_label' => 'Email',
            'password_label' => 'Password',
            'submit_text' => 'Sign In',
            'forgot_url' => '',
            'register_url' => '',
            'remember_me' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🔐 Login Form';
    }
}
