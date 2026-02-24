<?php

declare(strict_types=1);

use Crumbls\Layup\View\Row;

it('make() creates a Row', function () {
    expect(Row::make())->toBeInstanceOf(Row::class);
});

it('getContentFormSchema() has direction/justify/align/wrap/full_width fields', function () {
    $schema = Row::getContentFormSchema();
    $names = collect($schema)->map(fn ($c) => $c->getName())->toArray();
    expect($names)->toContain('direction', 'justify', 'align', 'wrap', 'full_width');
});

it('render() returns a View', function () {
    $row = Row::make();
    expect($row->render())->toBeInstanceOf(\Illuminate\Contracts\View\View::class);
});
