<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class GalleryWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'gallery';
    }

    public static function getLabel(): string
    {
        return 'Gallery';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-squares-2x2';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('images')
                ->label('Images')
                ->image()
                ->multiple()
                ->reorderable()
                ->directory('layup/gallery')
                ->columnSpanFull(),
            Select::make('columns')
                ->label('Columns')
                ->options([
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                    '5' => '5 Columns',
                    '6' => '6 Columns',
                ])
                ->default('3'),
            Select::make('gap')
                ->label('Gap')
                ->options([
                    '0' => 'None',
                    '0.25rem' => 'Extra Small',
                    '0.5rem' => 'Small',
                    '1rem' => 'Medium',
                    '1.5rem' => 'Large',
                ])
                ->default('0.5rem'),
            Toggle::make('lightbox')
                ->label('Enable Lightbox')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'images' => [],
            'columns' => '3',
            'gap' => '0.5rem',
            'lightbox' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['images'] ?? []);

        return "🖼 Gallery · {$count} images";
    }
}
