<?php
declare(strict_types=1);
namespace Crumbls\Layup\View;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
class ImageTextWidget extends BaseWidget
{
    public static function getType(): string { return 'image-text'; }
    public static function getLabel(): string { return 'Image + Text'; }
    public static function getIcon(): string { return 'heroicon-o-newspaper'; }
    public static function getCategory(): string { return 'content'; }
    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('image')->label('Image')->image()->directory('layup/image-text'),
            RichEditor::make('content')->label('Content')->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'h2', 'h3'])->columnSpanFull(),
            TextInput::make('heading')->label('Heading')->nullable(),
            Select::make('image_position')->label('Image Position')->options(['left' => 'Left', 'right' => 'Right'])->default('left'),
            Select::make('image_width')->label('Image Width')->options(['1/3' => '33%', '1/2' => '50%', '2/5' => '40%', '3/5' => '60%'])->default('1/2'),
        ];
    }
    public static function getDefaultData(): array { return ['image' => '', 'content' => '', 'heading' => '', 'image_position' => 'left', 'image_width' => '1/2']; }
    public static function getPreview(array $data): string { return '📰 ' . ($data['heading'] ?? 'Image + Text'); }
}
