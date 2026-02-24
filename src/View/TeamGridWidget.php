<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TeamGridWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'team-grid';
    }

    public static function getLabel(): string
    {
        return 'Team Grid';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-user-group';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('members')
                ->label('Team Members')
                ->schema([
                    FileUpload::make('photo')
                        ->label('Photo')
                        ->image()
                        ->avatar()
                        ->directory('layup/team'),
                    TextInput::make('name')
                        ->label('Name')
                        ->required(),
                    TextInput::make('role')
                        ->label('Role')
                        ->nullable(),
                    TextInput::make('linkedin')
                        ->label('LinkedIn URL')
                        ->url()
                        ->nullable(),
                    TextInput::make('twitter')
                        ->label('Twitter URL')
                        ->url()
                        ->nullable(),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
            Select::make('columns')
                ->label('Columns')
                ->options(['2' => '2', '3' => '3', '4' => '4', '5' => '5'])
                ->default('3'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'members' => [],
            'columns' => '3',
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['members'] ?? []);

        return "👥 Team Grid ({$count} members)";
    }
}
