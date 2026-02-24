<?php

declare(strict_types=1);

namespace Crumbls\Layup\Resources\PageResource\Pages;

use Crumbls\Layup\Models\Page;
use Crumbls\Layup\Resources\PageResource;
use Crumbls\Layup\Support\ContentValidator;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import')
                ->label('Import')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->form([
                    FileUpload::make('file')
                        ->label('JSON File')
                        ->acceptedFileTypes(['application/json'])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $path = storage_path('app/' . $data['file']);

                    if (! file_exists($path)) {
                        Notification::make()->danger()->title('File not found')->send();

                        return;
                    }

                    $json = json_decode(file_get_contents($path), true);
                    @unlink($path);

                    if (! $json || ! isset($json['content'])) {
                        Notification::make()->danger()->title('Invalid Layup JSON file')->send();

                        return;
                    }

                    $validator = new ContentValidator;
                    if (! $validator->validate($json['content'])) {
                        Notification::make()->danger()->title('Invalid page content structure')->send();

                        return;
                    }

                    $modelClass = config('layup.pages.model', Page::class);
                    $slug = $json['slug'] ?? Str::slug($json['title'] ?? 'imported');

                    // Ensure unique slug
                    if ($modelClass::where('slug', $slug)->exists()) {
                        $slug .= '-' . Str::random(4);
                    }

                    $modelClass::create([
                        'title' => $json['title'] ?? 'Imported Page',
                        'slug' => $slug,
                        'content' => $json['content'],
                        'meta' => $json['meta'] ?? [],
                        'status' => 'draft',
                    ]);

                    Notification::make()->success()->title('Page imported successfully')->send();
                }),
        ];
    }
}
