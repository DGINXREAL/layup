<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FeatureGridWidget extends BaseWidget
{
    public static function getType(): string { return 'feature-grid'; }
    public static function getLabel(): string { return 'Feature Grid'; }
    public static function getIcon(): string { return 'heroicon-o-squares-plus'; }
    public static function getCategory(): string { return 'content'; }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('features')
                ->label('Features')
                ->schema([
                    TextInput::make('emoji')->label('Emoji/Icon')->default('🚀'),
                    TextInput::make('title')->label('Title')->required(),
                    TextInput::make('description')->label('Description')->nullable(),
                ])
                ->defaultItems(6)
                ->columnSpanFull(),
            Select::make('columns')
                ->label('Columns')
                ->options(['2' => '2', '3' => '3', '4' => '4'])
                ->default('3'),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['features' => [], 'columns' => '3'];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['features'] ?? []);
        return "✨ Feature Grid ({$count})";
    }
}
