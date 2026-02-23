<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Illuminate\Contracts\View\View;

class Row extends BaseView
{
    /**
     * Create a row with column children.
     *
     * @param  array<Column>  $columns
     */
    public static function make(array $data = [], array $children = []): static
    {
        return new static($data, $children);
    }

    public function render(): View
    {
        return view('layup::components.row', [
            'children' => $this->children,
            'data' => $this->data,
        ]);
    }
}
