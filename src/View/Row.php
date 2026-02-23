<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
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
            Select::make('gap')
                ->label('Gap')
                ->options([
                    'gap-0' => 'None',
                    'gap-1' => '0.25rem',
                    'gap-2' => '0.5rem',
                    'gap-4' => '1rem',
                    'gap-6' => '1.5rem',
                    'gap-8' => '2rem',
                    'gap-12' => '3rem',
                ])
                ->default('gap-4'),
            Select::make('wrap')
                ->label('Wrap')
                ->options([
                    'nowrap' => 'No Wrap',
                    'wrap' => 'Wrap',
                    'wrap-reverse' => 'Wrap Reverse',
                ])
                ->default('wrap'),
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
