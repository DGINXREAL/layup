<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class MasonryWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'masonry';
    }

    public static function getLabel(): string
    {
        return 'Masonry Gallery';
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
                ->directory('layup/masonry')
                ->columnSpanFull(),
            Select::make('columns')
                ->label('Columns')
                ->options(['2' => '2', '3' => '3', '4' => '4', '5' => '5'])
                ->default('3'),
            Select::make('gap')
                ->label('Gap')
                ->options([
                    '0.25rem' => 'Extra Small',
                    '0.5rem' => 'Small',
                    '1rem' => 'Medium',
                    '1.5rem' => 'Large',
                ])
                ->default('0.5rem'),
            Toggle::make('rounded')
                ->label('Rounded Corners')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'images' => [],
            'columns' => '3',
            'gap' => '0.5rem',
            'rounded' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['images'] ?? []);

        return "🧱 Masonry ({$count} images)";
    }
}
