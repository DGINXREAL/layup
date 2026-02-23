<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;

class PersonWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'person';
    }

    public static function getLabel(): string
    {
        return 'Person';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-user-circle';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Name')
                ->required(),
            TextInput::make('role')
                ->label('Role / Position')
                ->nullable(),
            FileUpload::make('photo')
                ->label('Photo')
                ->image()
                ->directory('layup/people'),
            RichEditor::make('bio')
                ->label('Bio')
                ->columnSpanFull(),
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->nullable(),
            TextInput::make('website')
                ->label('Website')
                ->url()
                ->nullable(),
            TextInput::make('facebook')
                ->label('Facebook URL')
                ->url()
                ->nullable(),
            TextInput::make('twitter')
                ->label('X / Twitter URL')
                ->url()
                ->nullable(),
            TextInput::make('linkedin')
                ->label('LinkedIn URL')
                ->url()
                ->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'name' => '',
            'role' => '',
            'photo' => '',
            'bio' => '',
            'email' => '',
            'website' => '',
            'facebook' => '',
            'twitter' => '',
            'linkedin' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        $name = $data['name'] ?? '';
        $role = $data['role'] ?? '';

        return $name ? "👤 {$name}" . ($role ? " — {$role}" : '') : '(empty person)';
    }
}
