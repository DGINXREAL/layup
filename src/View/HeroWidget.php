<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class HeroWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'hero';
    }

    public static function getLabel(): string
    {
        return 'Hero Section';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-rectangle-group';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('heading')
                ->label('Heading')
                ->required()
                ->columnSpanFull(),
            TextInput::make('subheading')
                ->label('Subheading')
                ->nullable()
                ->columnSpanFull(),
            RichEditor::make('description')
                ->label('Description')
                ->toolbarButtons(['bold', 'italic', 'link'])
                ->columnSpanFull(),
            TextInput::make('primary_button_text')
                ->label('Primary Button Text')
                ->nullable(),
            TextInput::make('primary_button_url')
                ->label('Primary Button URL')
                ->url()
                ->nullable(),
            TextInput::make('secondary_button_text')
                ->label('Secondary Button Text')
                ->nullable(),
            TextInput::make('secondary_button_url')
                ->label('Secondary Button URL')
                ->url()
                ->nullable(),
            FileUpload::make('background_image')
                ->label('Background Image')
                ->image()
                ->directory('layup/heroes'),
            Select::make('alignment')
                ->label('Content Alignment')
                ->options(['left' => 'Left', 'center' => 'Center', 'right' => 'Right'])
                ->default('center'),
            Select::make('height')
                ->label('Height')
                ->options([
                    'auto' => 'Auto',
                    '50vh' => 'Half Screen',
                    '75vh' => 'Three-Quarter Screen',
                    '100vh' => 'Full Screen',
                ])
                ->default('auto'),
            TextInput::make('overlay_color')
                ->label('Overlay Color')
                ->type('color')
                ->default('#000000'),
            TextInput::make('overlay_opacity')
                ->label('Overlay Opacity (0-100)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->default(50),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'heading' => '',
            'subheading' => '',
            'description' => '',
            'primary_button_text' => '',
            'primary_button_url' => '#',
            'secondary_button_text' => '',
            'secondary_button_url' => '#',
            'background_image' => '',
            'alignment' => 'center',
            'height' => 'auto',
            'overlay_color' => '#000000',
            'overlay_opacity' => 50,
        ];
    }

    public static function getPreview(array $data): string
    {
        return '🦸 ' . ($data['heading'] ?? '(empty hero)');
    }
}
