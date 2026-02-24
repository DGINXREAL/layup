<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BannerWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'banner';
    }

    public static function getLabel(): string
    {
        return 'Banner';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-megaphone';
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
                ->required(),
            TextInput::make('subtext')
                ->label('Subtext')
                ->nullable(),
            TextInput::make('cta_text')
                ->label('CTA Text')
                ->nullable(),
            TextInput::make('cta_url')
                ->label('CTA URL')
                ->url()
                ->nullable(),
            FileUpload::make('bg_image')
                ->label('Background Image')
                ->image()
                ->directory('layup/banners'),
            TextInput::make('bg_color')
                ->label('Background Color')
                ->type('color')
                ->default('#1e40af'),
            TextInput::make('text_color_banner')
                ->label('Text Color')
                ->type('color')
                ->default('#ffffff'),
            Select::make('height')
                ->label('Height')
                ->options(['auto' => 'Auto', '200px' => 'Small', '300px' => 'Medium', '400px' => 'Large'])
                ->default('auto'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'heading' => '',
            'subtext' => '',
            'cta_text' => '',
            'cta_url' => '',
            'bg_image' => '',
            'bg_color' => '#1e40af',
            'text_color_banner' => '#ffffff',
            'height' => 'auto',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '📣 ' . ($data['heading'] ?? '(empty banner)');
    }
}
