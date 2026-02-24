<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class CodeWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'code';
    }

    public static function getLabel(): string
    {
        return 'Code Block';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-code-bracket';
    }

    public static function getCategory(): string
    {
        return 'advanced';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Textarea::make('code')
                ->label('Code')
                ->rows(10)
                ->columnSpanFull()
                ->required(),
            Select::make('language')
                ->label('Language')
                ->options([
                    'plaintext' => 'Plain Text',
                    'html' => 'HTML',
                    'css' => 'CSS',
                    'javascript' => 'JavaScript',
                    'php' => 'PHP',
                    'python' => 'Python',
                    'ruby' => 'Ruby',
                    'json' => 'JSON',
                    'yaml' => 'YAML',
                    'bash' => 'Bash',
                    'sql' => 'SQL',
                    'markdown' => 'Markdown',
                ])
                ->default('plaintext'),
            TextInput::make('filename')
                ->label('Filename')
                ->placeholder('e.g. example.php')
                ->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'code' => '',
            'language' => 'plaintext',
            'filename' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        $lang = $data['language'] ?? 'plaintext';
        $lines = substr_count($data['code'] ?? '', "\n") + 1;

        return "💻 {$lang} ({$lines} lines)";
    }
}
