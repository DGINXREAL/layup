<?php

declare(strict_types=1);

use Crumbls\Layup\Support\ContentValidator;

beforeEach(function () {
    $this->validator = new ContentValidator();
});

it('valid content structure passes', function () {
    $content = [
        'rows' => [
            [
                'columns' => [
                    [
                        'widgets' => [
                            ['type' => 'text', 'data' => ['content' => 'hi']],
                        ],
                    ],
                ],
            ],
        ],
    ];
    expect($this->validator->validate($content)->passes())->toBeTrue();
});

it('missing rows key fails', function () {
    $result = $this->validator->validate(['something' => 'else']);
    expect($result->passes())->toBeFalse();
    expect($result->errors())->toContain('Missing "rows" key.');
});

it('row without columns fails', function () {
    $result = $this->validator->validate(['rows' => [['id' => 'r1']]]);
    expect($result->passes())->toBeFalse();
    expect($result->errors()[0])->toContain('missing "columns"');
});

it('column without widgets fails', function () {
    $result = $this->validator->validate([
        'rows' => [['columns' => [['id' => 'c1']]]],
    ]);
    expect($result->passes())->toBeFalse();
    expect($result->errors()[0])->toContain('missing "widgets"');
});

it('widget without type fails', function () {
    $result = $this->validator->validate([
        'rows' => [['columns' => [['widgets' => [['data' => []]]]]]],
    ]);
    expect($result->passes())->toBeFalse();
    expect($result->errors()[0])->toContain('missing "type"');
});

it('returns error messages array', function () {
    $result = $this->validator->validate(['rows' => [['id' => 'r1']]]);
    expect($result->errors())->toBeArray()->not->toBeEmpty();
});

it('non-array content fails', function () {
    $result = $this->validator->validate('not an array');
    expect($result->passes())->toBeFalse();
});
