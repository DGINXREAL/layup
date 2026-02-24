<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class AvatarGroupWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'avatar-group';
    }

    public static function getLabel(): string
    {
        return 'Avatar Group';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-users';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('avatars')
                ->label('Avatars')
                ->image()
                ->avatar()
                ->multiple()
                ->reorderable()
                ->directory('layup/avatars')
                ->columnSpanFull(),
            TextInput::make('extra_count')
                ->label('Extra Count (e.g. "+12")')
                ->placeholder('+12')
                ->nullable(),
            TextInput::make('label')
                ->label('Label')
                ->placeholder('Join 1,200+ users')
                ->nullable(),
            Select::make('size')
                ->label('Size')
                ->options(['sm' => 'Small (32px)', 'md' => 'Medium (40px)', 'lg' => 'Large (48px)'])
                ->default('md'),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['avatars' => [], 'extra_count' => '', 'label' => '', 'size' => 'md'];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['avatars'] ?? []);

        return "👥 {$count} avatars" . (empty($data['extra_count']) ? '' : " {$data['extra_count']}");
    }
}
