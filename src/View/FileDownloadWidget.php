<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class FileDownloadWidget extends BaseWidget
{
    public static function getType(): string { return 'file-download'; }
    public static function getLabel(): string { return 'File Download'; }
    public static function getIcon(): string { return 'heroicon-o-arrow-down-tray'; }
    public static function getCategory(): string { return 'interactive'; }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')->label('Title')->required(),
            TextInput::make('description')->label('Description')->nullable(),
            FileUpload::make('file')->label('File')->directory('layup/downloads')->required(),
            TextInput::make('button_text')->label('Button Text')->default('Download'),
            TextInput::make('file_size')->label('File Size (display)')->placeholder('2.4 MB')->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['title' => '', 'description' => '', 'file' => '', 'button_text' => 'Download', 'file_size' => ''];
    }

    public static function getPreview(array $data): string
    {
        return '📥 ' . ($data['title'] ?? 'File Download');
    }
}
