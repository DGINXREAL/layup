<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Contracts\View\View;

class Row extends BaseView
{
    /**
     * @param  array<Column>  $columns
     */
    public static function make(array $data = [], array $children = []): static
    {
        return new static($data, $children);
    }

    /**
     * Content tab: flex direction, justify, align, gap, wrap.
     */
    public static function getContentFormSchema(): array
    {
        return [
            Select::make('direction')
                ->label('Direction')
                ->options([
                    'row' => 'Row (Horizontal)',
                    'column' => 'Column (Vertical)',
                    'row-reverse' => 'Row Reverse',
                    'column-reverse' => 'Column Reverse',
                ])
                ->default('row'),
            Select::make('justify')
                ->label('Justify Content')
                ->options([
                    'start' => 'Start',
                    'center' => 'Center',
                    'end' => 'End',
                    'between' => 'Space Between',
                    'around' => 'Space Around',
                    'evenly' => 'Space Evenly',
                ])
                ->default('start'),
            Select::make('align')
                ->label('Align Items')
                ->options([
                    'start' => 'Start',
                    'center' => 'Center',
                    'end' => 'End',
                    'stretch' => 'Stretch',
                    'baseline' => 'Baseline',
                ])
                ->default('stretch'),
            Select::make('wrap')
                ->label('Wrap')
                ->options([
                    'nowrap' => 'No Wrap',
                    'wrap' => 'Wrap',
                    'wrap-reverse' => 'Wrap Reverse',
                ])
                ->default('wrap'),
            Toggle::make('full_width')
                ->label('Full Width')
                ->helperText('Bypass the container max-width for edge-to-edge rows')
                ->default(false),
        ];
    }

    public function render(): View
    {
        return view('layup::components.row', [
            'children' => $this->children,
            'data' => $this->data,
        ]);
    }
}
