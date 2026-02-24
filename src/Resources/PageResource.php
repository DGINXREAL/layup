<?php

declare(strict_types=1);

namespace Crumbls\Layup\Resources;

use BackedEnum;
use Crumbls\Layup\Models\Page;
use Crumbls\Layup\Resources\PageResource\Pages;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Collection;
use Crumbls\Layup\Support\PageTemplate;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class PageResource extends Resource
{
    protected static ?string $model = null;

    public static function getModel(): string
    {
        return config('layup.pages.model', Page::class);
    }

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $slug = 'pages';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Template')
                    ->schema([
                        Select::make('template')
                            ->label('Start from template')
                            ->options(PageTemplate::options())
                            ->placeholder('Blank page')
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, \Filament\Schemas\Components\Utilities\Set $set) {
                                if ($state) {
                                    $template = PageTemplate::get($state);
                                    if ($template) {
                                        $set('content', $template['content']);
                                    }
                                }
                            }),
                    ])
                    ->hiddenOn('edit'),

                Section::make('Page Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, \Filament\Schemas\Components\Utilities\Set $set, ?Page $record) =>
                                $record === null ? $set('slug', Str::slug($state)) : null
                            ),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Page::class, 'slug', ignoreRecord: true),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta.description')
                            ->label('Meta Description')
                            ->maxLength(160),
                        TextInput::make('meta.keywords')
                            ->label('Meta Keywords'),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'warning',
                        'published' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(function (Page $record) {
                        $modelClass = config('layup.pages.model', Page::class);
                        $modelClass::create([
                            'title' => $record->title . ' (Copy)',
                            'slug' => $record->slug . '-copy-' . Str::random(4),
                            'content' => $record->content,
                            'meta' => $record->meta,
                            'status' => 'draft',
                        ]);
                    }),
                Action::make('export')
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function (Page $record) {
                        $json = json_encode([
                            'title' => $record->title,
                            'slug' => $record->slug,
                            'content' => $record->content,
                            'meta' => $record->meta,
                            'exported_at' => now()->toIso8601String(),
                            'layup_version' => '1.0',
                        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

                        return response()->streamDownload(
                            fn () => print($json),
                            Str::slug($record->title) . '.json',
                            ['Content-Type' => 'application/json'],
                        );
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')
                        ->label('Publish')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['status' => 'published'])),
                    BulkAction::make('unpublish')
                        ->label('Unpublish')
                        ->icon('heroicon-o-x-circle')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['status' => 'draft'])),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
