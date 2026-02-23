<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Storage;

class ImageWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'image';
    }

    public static function getLabel(): string
    {
        return 'Image';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-photo';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getFormSchema(): array
    {
        return [
            FileUpload::make('src')
                ->label('Image')
                ->image()
                ->directory('layup/images'),
            TextInput::make('alt')
                ->label('Alt Text'),
            TextInput::make('caption')
                ->label('Caption'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'src' => '',
            'alt' => '',
            'caption' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        if (! empty($data['src'])) {
            $name = is_array($data['src']) ? 'uploaded image' : basename($data['src']);

            return "🖼 {$name}";
        }

        return '(no image)';
    }

    public static function onDelete(array $data): void
    {
        if (! empty($data['src']) && is_string($data['src'])) {
            Storage::disk('public')->delete($data['src']);
        }
    }
}
