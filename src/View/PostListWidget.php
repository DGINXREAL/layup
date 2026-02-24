<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PostListWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'post-list';
    }

    public static function getLabel(): string
    {
        return 'Post List';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-document-text';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('model')
                ->label('Model Class')
                ->placeholder('App\\Models\\Post')
                ->helperText('Eloquent model with title, slug, excerpt, published_at')
                ->nullable(),
            TextInput::make('limit')
                ->label('Number of Posts')
                ->numeric()
                ->default(6)
                ->minValue(1)
                ->maxValue(50),
            Select::make('columns')
                ->label('Columns')
                ->options(['1' => '1', '2' => '2', '3' => '3'])
                ->default('3'),
            Select::make('order')
                ->label('Order By')
                ->options([
                    'latest' => 'Newest First',
                    'oldest' => 'Oldest First',
                    'title' => 'Title A-Z',
                ])
                ->default('latest'),
            Toggle::make('show_excerpt')
                ->label('Show Excerpt')
                ->default(true),
            Toggle::make('show_date')
                ->label('Show Date')
                ->default(true),
            TextInput::make('read_more_text')
                ->label('Read More Text')
                ->default('Read more →'),
            TextInput::make('empty_message')
                ->label('Empty State Message')
                ->default('No posts yet.'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'model' => '',
            'limit' => 6,
            'columns' => '3',
            'order' => 'latest',
            'show_excerpt' => true,
            'show_date' => true,
            'read_more_text' => 'Read more →',
            'empty_message' => 'No posts yet.',
        ];
    }

    public static function getPreview(array $data): string
    {
        $limit = $data['limit'] ?? 6;

        return "📝 Post List ({$limit} posts)";
    }
}
