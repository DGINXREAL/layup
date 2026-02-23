<?php

namespace Crumbls\Layup\Resources\PageResource\Pages;

use Crumbls\Layup\Models\Page;
use Crumbls\Layup\Resources\PageResource;
use Crumbls\Layup\Support\WidgetRegistry;
use Filament\Actions;
use Crumbls\Layup\Forms\Components\SpanPicker;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected string $view = 'layup::livewire.page-builder';

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';

    /** @var array Excluded from Filament's form hydration via $except */
    public array $pageContent = [];

    public ?string $editingRowId = null;
    public ?string $editingColumnId = null;
    public ?string $editingWidgetId = null;
    public ?string $editingWidgetType = null;

    public array $rowSettings = [];
    public array $columnSettings = [];
    public array $widgetData = [];

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $this->pageContent = $this->record->content ?? ['rows' => []];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // ─── Row Operations ──────────────────────────────────────

    protected function refreshContent(): void
    {
        $this->record->refresh();
        $this->pageContent = $this->record->content ?? ['rows' => []];
    }

    protected function syncContent(): void
    {
        $this->dispatch('content-updated', $this->pageContent);
    }

    /**
     * Restore content from Alpine's undo/redo history.
     */
    public function restoreContent(array $content): void
    {
        $this->pageContent = $content;
        $this->record->update(['content' => $this->pageContent]);
    }

    public function addRow(array $spans): void
    {
        $row = [
            'id' => 'row_' . Str::random(8),
            'settings' => [
                'gap' => 'gap-4',
                'alignment' => 'justify-start',
                'verticalAlignment' => 'items-stretch',
            ],
            'columns' => collect($spans)->map(fn (int $span) => [
                'id' => 'col_' . Str::random(8),
                'span' => ['sm' => 12, 'md' => $span, 'lg' => $span, 'xl' => $span],
                'settings' => ['padding' => 'p-4', 'background' => 'transparent'],
                'widgets' => [],
            ])->values()->all(),
        ];

        $this->pageContent['rows'][] = $row;
        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    public function addRowAt(array $spans, int $position): void
    {
        $row = [
            'id' => 'row_' . Str::random(8),
            'settings' => [
                'gap' => 'gap-4',
                'alignment' => 'justify-start',
                'verticalAlignment' => 'items-stretch',
            ],
            'columns' => collect($spans)->map(fn (int $span) => [
                'id' => 'col_' . Str::random(8),
                'span' => ['sm' => 12, 'md' => $span, 'lg' => $span, 'xl' => $span],
                'settings' => ['padding' => 'p-4', 'background' => 'transparent'],
                'widgets' => [],
            ])->values()->all(),
        ];

        array_splice($this->pageContent['rows'], $position, 0, [$row]);
        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    public function deleteRow(string $rowId): void
    {
        $this->pageContent['rows'] = collect($this->pageContent['rows'])
            ->reject(fn ($row) => $row['id'] === $rowId)
            ->values()
            ->all();

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    public function moveRow(string $rowId, string $direction): void
    {
        $rows = collect($this->pageContent['rows']);
        $index = $rows->search(fn ($r) => $r['id'] === $rowId);

        if ($index === false) return;

        $newIndex = $direction === 'up' ? $index - 1 : $index + 1;
        if ($newIndex < 0 || $newIndex >= $rows->count()) return;

        $arr = $rows->all();
        [$arr[$index], $arr[$newIndex]] = [$arr[$newIndex], $arr[$index]];
        $this->pageContent['rows'] = array_values($arr);

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    /**
     * Add a column to an existing row.
     */
    public function addColumn(string $rowId, int $span = 6): void
    {
        $this->refreshContent();

        foreach ($this->pageContent['rows'] as &$row) {
            if ($row['id'] === $rowId) {
                $row['columns'][] = [
                    'id' => 'col_' . Str::random(8),
                    'span' => ['sm' => 12, 'md' => $span, 'lg' => $span, 'xl' => $span],
                    'settings' => ['padding' => 'p-4', 'background' => 'transparent'],
                    'widgets' => [],
                ];
                break;
            }
        }

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    /**
     * Delete a column from a row.
     */
    public function deleteColumn(string $rowId, string $columnId): void
    {
        $this->refreshContent();

        foreach ($this->pageContent['rows'] as &$row) {
            if ($row['id'] === $rowId) {
                $row['columns'] = collect($row['columns'])
                    ->reject(fn ($col) => $col['id'] === $columnId)
                    ->values()
                    ->all();
                break;
            }
        }

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    /**
     * Move a column left or right within a row.
     */
    public function moveColumn(string $rowId, string $columnId, string $direction): void
    {
        $this->refreshContent();

        foreach ($this->pageContent['rows'] as &$row) {
            if ($row['id'] !== $rowId) continue;

            $cols = collect($row['columns']);
            $index = $cols->search(fn ($c) => $c['id'] === $columnId);
            if ($index === false) break;

            $newIndex = $direction === 'left' ? $index - 1 : $index + 1;
            if ($newIndex < 0 || $newIndex >= $cols->count()) break;

            $arr = $cols->all();
            [$arr[$index], $arr[$newIndex]] = [$arr[$newIndex], $arr[$index]];
            $row['columns'] = array_values($arr);
            break;
        }

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    /**
     * Move a widget up or down within a column.
     */
    public function moveWidget(string $rowId, string $columnId, string $widgetId, string $direction): void
    {
        $this->refreshContent();

        foreach ($this->pageContent['rows'] as &$row) {
            if ($row['id'] !== $rowId) continue;
            foreach ($row['columns'] as &$col) {
                if ($col['id'] !== $columnId) continue;

                $widgets = collect($col['widgets']);
                $index = $widgets->search(fn ($w) => $w['id'] === $widgetId);
                if ($index === false) break 2;

                $newIndex = $direction === 'up' ? $index - 1 : $index + 1;
                if ($newIndex < 0 || $newIndex >= $widgets->count()) break 2;

                $arr = $widgets->all();
                [$arr[$index], $arr[$newIndex]] = [$arr[$newIndex], $arr[$index]];
                $col['widgets'] = array_values($arr);
                break 2;
            }
        }

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    public function moveWidgetTo(string $sourceRowId, string $sourceColId, string $widgetId, string $targetRowId, string $targetColId, int $position): void
    {
        $this->refreshContent();

        $widget = null;

        // Remove from source
        foreach ($this->pageContent['rows'] as &$row) {
            if ($row['id'] !== $sourceRowId) continue;
            foreach ($row['columns'] as &$col) {
                if ($col['id'] !== $sourceColId) continue;
                $index = collect($col['widgets'])->search(fn ($w) => $w['id'] === $widgetId);
                if ($index === false) return;
                $widget = $col['widgets'][$index];
                array_splice($col['widgets'], $index, 1);
                break 2;
            }
        }
        unset($row, $col);

        if (!$widget) return;

        // Insert into target
        foreach ($this->pageContent['rows'] as &$row) {
            if ($row['id'] !== $targetRowId) continue;
            foreach ($row['columns'] as &$col) {
                if ($col['id'] !== $targetColId) continue;
                array_splice($col['widgets'], $position, 0, [$widget]);
                break 2;
            }
        }
        unset($row, $col);

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    public function moveRowTo(string $rowId, int $targetIndex): void
    {
        $this->refreshContent();

        $rows = $this->pageContent['rows'];
        $sourceIndex = collect($rows)->search(fn ($r) => $r['id'] === $rowId);
        if ($sourceIndex === false) return;

        $row = $rows[$sourceIndex];
        array_splice($rows, $sourceIndex, 1);
        array_splice($rows, $targetIndex, 0, [$row]);

        $this->pageContent['rows'] = $rows;
        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    // ─── Duplication ─────────────────────────────────────────

    public function duplicateRow(string $rowId): void
    {
        $this->refreshContent();

        $rows = collect($this->pageContent['rows']);
        $index = $rows->search(fn ($r) => $r['id'] === $rowId);
        if ($index === false) return;

        $original = $rows[$index];
        $clone = $this->deepCloneRow($original);

        array_splice($this->pageContent['rows'], $index + 1, 0, [$clone]);
        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();

        Notification::make()->title('Row duplicated')->success()->duration(2000)->send();
    }

    public function duplicateWidget(string $rowId, string $columnId, string $widgetId): void
    {
        $this->refreshContent();

        foreach ($this->pageContent['rows'] as &$row) {
            if ($row['id'] !== $rowId) continue;
            foreach ($row['columns'] as &$col) {
                if ($col['id'] !== $columnId) continue;

                $widgets = collect($col['widgets']);
                $index = $widgets->search(fn ($w) => $w['id'] === $widgetId);
                if ($index === false) break 2;

                $original = $col['widgets'][$index];
                $clone = [
                    'id' => 'widget_' . Str::random(8),
                    'type' => $original['type'],
                    'data' => $original['data'] ?? [],
                ];

                array_splice($col['widgets'], $index + 1, 0, [$clone]);
                break 2;
            }
        }

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();

        Notification::make()->title('Widget duplicated')->success()->duration(2000)->send();
    }

    protected function deepCloneRow(array $row): array
    {
        $clone = $row;
        $clone['id'] = 'row_' . Str::random(8);
        $clone['columns'] = collect($row['columns'])->map(function ($col) {
            $col['id'] = 'col_' . Str::random(8);
            $col['widgets'] = collect($col['widgets'] ?? [])->map(function ($widget) {
                $widget['id'] = 'widget_' . Str::random(8);
                return $widget;
            })->all();
            return $col;
        })->all();

        return $clone;
    }

    // ─── Row Settings Slideover ──────────────────────────────

    public function editRow(string $rowId): void
    {
        $this->editingRowId = $rowId;
        $row = collect($this->pageContent['rows'])->firstWhere('id', $rowId);
        $this->rowSettings = $row['settings'] ?? [];

        $this->mountAction('editRowAction');
    }

    public function editRowAction(): Action
    {
        return Action::make('editRowAction')
            ->label('Row Settings')
            ->slideOver()
            ->fillForm(fn () => $this->rowSettings)
            ->form([
                Select::make('gap')
                    ->label('Column Gap')
                    ->options([
                        'gap-0' => 'None',
                        'gap-2' => 'Extra Small',
                        'gap-4' => 'Small',
                        'gap-6' => 'Medium',
                        'gap-8' => 'Large',
                        'gap-12' => 'Extra Large',
                    ])
                    ->default('gap-4'),
                Select::make('alignment')
                    ->label('Horizontal Alignment')
                    ->options([
                        'justify-start' => 'Start',
                        'justify-center' => 'Center',
                        'justify-end' => 'End',
                        'justify-between' => 'Space Between',
                        'justify-around' => 'Space Around',
                    ])
                    ->default('justify-start'),
                Select::make('verticalAlignment')
                    ->label('Vertical Alignment')
                    ->options([
                        'items-start' => 'Top',
                        'items-center' => 'Center',
                        'items-end' => 'Bottom',
                        'items-stretch' => 'Stretch',
                    ])
                    ->default('items-stretch'),
            ])
            ->action(function (array $data) {
                $this->refreshContent();
                $this->pageContent['rows'] = collect($this->pageContent['rows'])->map(function ($row) use ($data) {
                    if ($row['id'] === $this->editingRowId) {
                        $row['settings'] = $data;
                    }
                    return $row;
                })->all();

                $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
                $this->editingRowId = null;

                Notification::make()->title('Row updated')->success()->duration(2000)->send();
            });
    }

    // ─── Column Settings Slideover ───────────────────────────

    public function editColumn(string $rowId, string $columnId): void
    {
        $this->editingRowId = $rowId;
        $this->editingColumnId = $columnId;

        $row = collect($this->pageContent['rows'])->firstWhere('id', $rowId);
        $col = collect($row['columns'] ?? [])->firstWhere('id', $columnId);

        $this->columnSettings = array_merge(
            $col['settings'] ?? [],
            ['span_sm' => $col['span']['sm'] ?? 12],
            ['span_md' => $col['span']['md'] ?? 6],
            ['span_lg' => $col['span']['lg'] ?? 6],
            ['span_xl' => $col['span']['xl'] ?? 6],
        );

        $this->mountAction('editColumnAction');
    }

    public function editColumnAction(): Action
    {
        return Action::make('editColumnAction')
            ->label('Column Settings')
            ->slideOver()
            ->fillForm(fn () => $this->columnSettings)
            ->form([
                Section::make('Column Widths')
                    ->schema([
                        SpanPicker::make('span_sm')
                            ->breakpointLabel('Small')
                            ->color('#f97316')
                            ->default(12),
                        SpanPicker::make('span_md')
                            ->breakpointLabel('Medium')
                            ->color('#22c55e')
                            ->default(6),
                        SpanPicker::make('span_lg')
                            ->breakpointLabel('Large')
                            ->color('#3b82f6')
                            ->default(6),
                        SpanPicker::make('span_xl')
                            ->breakpointLabel('Extra Large')
                            ->color('#a855f7')
                            ->default(6),
                    ]),
                Select::make('padding')
                    ->label('Padding')
                    ->options([
                        'p-0' => 'None',
                        'p-2' => 'Extra Small',
                        'p-4' => 'Small',
                        'p-6' => 'Medium',
                        'p-8' => 'Large',
                    ])
                    ->default('p-4'),
                TextInput::make('background')
                    ->label('Background Color')
                    ->default('transparent'),
            ])
            ->action(function (array $data) {
                $this->refreshContent();
                $this->pageContent['rows'] = collect($this->pageContent['rows'])->map(function ($row) use ($data) {
                    if ($row['id'] !== $this->editingRowId) return $row;

                    $row['columns'] = collect($row['columns'])->map(function ($col) use ($data) {
                        if ($col['id'] !== $this->editingColumnId) return $col;

                        $col['span'] = [
                            'sm' => (int) $data['span_sm'],
                            'md' => (int) $data['span_md'],
                            'lg' => (int) $data['span_lg'],
                            'xl' => (int) $data['span_xl'],
                        ];
                        $col['settings'] = [
                            'padding' => $data['padding'],
                            'background' => $data['background'],
                        ];

                        return $col;
                    })->all();

                    return $row;
                })->all();

                $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
                $this->editingRowId = null;
                $this->editingColumnId = null;

                Notification::make()->title('Column updated')->success()->duration(2000)->send();
            });
    }

    // ─── Widget Operations ───────────────────────────────────

    public function addWidget(string $rowId, string $columnId, string $widgetType): void
    {
        $registry = app(WidgetRegistry::class);
        $defaults = $registry->getDefaultData($widgetType);
        $data = $registry->fireOnCreate($widgetType, $defaults);

        $widget = [
            'id' => 'widget_' . Str::random(8),
            'type' => $widgetType,
            'data' => $data,
        ];

        foreach ($this->pageContent['rows'] as &$row) {
            foreach ($row['columns'] as &$col) {
                if ($col['id'] === $columnId) {
                    $col['widgets'][] = $widget;
                    break 2;
                }
            }
        }

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    public function editWidget(string $rowId, string $columnId, string $widgetId): void
    {
        $this->editingRowId = $rowId;
        $this->editingColumnId = $columnId;
        $this->editingWidgetId = $widgetId;

        $row = collect($this->pageContent['rows'])->firstWhere('id', $rowId);
        $col = collect($row['columns'])->firstWhere('id', $columnId);
        $widget = collect($col['widgets'])->firstWhere('id', $widgetId);

        $this->editingWidgetType = $widget['type'];
        $this->widgetData = $widget['data'] ?? [];

        $this->mountAction('editWidgetAction');
    }

    public function editWidgetAction(): Action
    {
        $registry = app(WidgetRegistry::class);

        return Action::make('editWidgetAction')
            ->label('Edit Widget')
            ->slideOver()
            ->fillForm(fn () => $this->widgetData)
            ->form(fn () => $registry->getFormSchema($this->editingWidgetType ?? 'text'))
            ->action(function (array $data) {
                $this->refreshContent();
                $registry = app(WidgetRegistry::class);
                $data = $registry->fireOnSave($this->editingWidgetType, $data);

                $this->pageContent['rows'] = collect($this->pageContent['rows'])->map(function ($row) use ($data) {
                    if ($row['id'] !== $this->editingRowId) return $row;

                    $row['columns'] = collect($row['columns'])->map(function ($col) use ($data) {
                        if ($col['id'] !== $this->editingColumnId) return $col;

                        $col['widgets'] = collect($col['widgets'])->map(function ($widget) use ($data) {
                            if ($widget['id'] === $this->editingWidgetId) {
                                $widget['data'] = $data;
                            }
                            return $widget;
                        })->all();

                        return $col;
                    })->all();

                    return $row;
                })->all();

                $this->record->update(['content' => $this->pageContent]);
                $this->syncContent();

                $this->editingRowId = null;
                $this->editingColumnId = null;
                $this->editingWidgetId = null;
                $this->editingWidgetType = null;

                Notification::make()->title('Widget updated')->success()->duration(2000)->send();
            });
    }

    public function deleteWidget(string $rowId, string $columnId, string $widgetId): void
    {
        $registry = app(WidgetRegistry::class);

        foreach ($this->pageContent['rows'] as &$row) {
            foreach ($row['columns'] as &$col) {
                if ($col['id'] === $columnId) {
                    $widget = collect($col['widgets'])->firstWhere('id', $widgetId);
                    if ($widget) {
                        $registry->fireOnDelete($widget['type'], $widget['data'] ?? []);
                    }
                    $col['widgets'] = collect($col['widgets'])
                        ->reject(fn ($w) => $w['id'] === $widgetId)
                        ->values()
                        ->all();
                    break 2;
                }
            }
        }

        $this->record->update(['content' => $this->pageContent]);
        $this->syncContent();
    }

    // ─── Properties for Alpine ───────────────────────────────

    public function getWidgetRegistryProperty(): array
    {
        return app(WidgetRegistry::class)->toJs();
    }

    public function getBreakpointsProperty(): array
    {
        return config('layup.breakpoints', []);
    }

    public function getRowTemplatesProperty(): array
    {
        return config('layup.row_templates', []);
    }

    public function getDefaultBreakpointProperty(): string
    {
        return config('layup.default_breakpoint', 'lg');
    }
}
