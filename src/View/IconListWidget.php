<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class IconListWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'icon-list';
    }

    public static function getLabel(): string
    {
        return 'Icon List';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-list-bullet';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('items')->label('Items')->schema([
                TextInput::make('icon')->label('Emoji/Icon')->default('✅'),
                TextInput::make('text')->label('Text')->required(),
                TextInput::make('description')->label('Description')->nullable(),
            ])->defaultItems(4)->columnSpanFull(),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['items' => []];
    }

    public static function getPreview(array $data): string
    {
        return '📋 Icon List (' . count($data['items'] ?? []) . ')';
    }
}
