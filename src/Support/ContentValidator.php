<?php

declare(strict_types=1);

namespace Crumbls\Layup\Support;

class ContentValidator
{
    protected bool $strict;

    public function __construct(bool $strict = false)
    {
        $this->strict = $strict;
    }

    public function validate(mixed $content): ValidationResult
    {
        $errors = [];

        if (!is_array($content)) {
            return new ValidationResult(['Content must be an array.']);
        }

        if (!array_key_exists('rows', $content)) {
            return new ValidationResult(['Missing "rows" key.']);
        }

        if (!is_array($content['rows'])) {
            return new ValidationResult(['"rows" must be an array.']);
        }

        foreach ($content['rows'] as $ri => $row) {
            if (!is_array($row) || !array_key_exists('columns', $row)) {
                $errors[] = "Row {$ri}: missing \"columns\" key.";
                continue;
            }

            if (!is_array($row['columns'])) {
                $errors[] = "Row {$ri}: \"columns\" must be an array.";
                continue;
            }

            foreach ($row['columns'] as $ci => $col) {
                if (!is_array($col) || !array_key_exists('widgets', $col)) {
                    $errors[] = "Row {$ri}, Column {$ci}: missing \"widgets\" key.";
                    continue;
                }

                if (!is_array($col['widgets'])) {
                    $errors[] = "Row {$ri}, Column {$ci}: \"widgets\" must be an array.";
                    continue;
                }

                foreach ($col['widgets'] as $wi => $widget) {
                    if (!is_array($widget) || !array_key_exists('type', $widget)) {
                        $errors[] = "Row {$ri}, Column {$ci}, Widget {$wi}: missing \"type\" key.";
                        continue;
                    }

                    if (!is_string($widget['type']) || $widget['type'] === '') {
                        $errors[] = "Row {$ri}, Column {$ci}, Widget {$wi}: \"type\" must be a non-empty string.";
                        continue;
                    }

                    if ($this->strict) {
                        $registry = app(WidgetRegistry::class);
                        if (!$registry->has($widget['type'])) {
                            $errors[] = "Row {$ri}, Column {$ci}, Widget {$wi}: unknown widget type \"{$widget['type']}\".";
                        }
                    }
                }
            }
        }

        return new ValidationResult($errors);
    }
}
