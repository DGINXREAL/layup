<?php
declare(strict_types=1);
namespace Crumbls\Layup\View;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
class ImageCardWidget extends BaseWidget
{
    public static function getType(): string { return 'image-card'; }
    public static function getLabel(): string { return 'Image Card'; }
    public static function getIcon(): string { return 'heroicon-o-photo'; }
    public static function getCategory(): string { return 'media'; }
    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('image')->label('Image')->image()->directory('layup/cards'),
            TextInput::make('title')->label('Title')->required(),
            TextInput::make('description')->label('Description')->nullable(),
            TextInput::make('link_url')->label('Link URL')->url()->nullable(),
            TextInput::make('link_text')->label('Link Text')->default('Read more →')->nullable(),
        ];
    }
    public static function getDefaultData(): array { return ['image' => '', 'title' => '', 'description' => '', 'link_url' => '', 'link_text' => 'Read more →']; }
    public static function getPreview(array $data): string { return '🖼 ' . ($data['title'] ?? 'Image Card'); }
}
