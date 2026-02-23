<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Illuminate\Contracts\View\View;

class Column extends BaseView
{
    protected array $span = [
        'sm' => 12,
        'md' => 12,
        'lg' => 12,
        'xl' => 12,
    ];

    public function __construct(array $data = [], array $children = [])
    {
        parent::__construct($data, $children);

        if (isset($data['span'])) {
            $this->span = array_merge($this->span, $data['span']);
        }
    }

    /**
     * Set the column span for one or all breakpoints.
     *
     * @param  int|array<string, int>  $span
     */
    public function span(int|array $span): static
    {
        if (is_int($span)) {
            $this->span = [
                'sm' => $span,
                'md' => $span,
                'lg' => $span,
                'xl' => $span,
            ];
        } else {
            $this->span = array_merge($this->span, $span);
        }

        return $this;
    }

    /**
     * Get the column span configuration.
     *
     * @return array<string, int>
     */
    public function getSpan(): array
    {
        return $this->span;
    }

    public function render(): View
    {
        return view('layup::components.column', [
            'children' => $this->children,
            'span' => $this->span,
            'data' => $this->data,
        ]);
    }
}
