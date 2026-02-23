<?php

declare(strict_types=1);

namespace Crumbls\Layup\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'layup_pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'meta' => 'array',
        ];
    }

    /**
     * content JSON structure:
     * {
     *   "rows": [
     *     {
     *       "id": "row_abc123",
     *       "settings": { "gap": "gap-4", "alignment": "justify-start", ... },
     *       "columns": [
     *         {
     *           "id": "col_def456",
     *           "span": { "sm": 12, "md": 6, "lg": 6, "xl": 6 },
     *           "settings": { "padding": "p-4", "background": "transparent", ... },
     *           "widgets": [
     *             {
     *               "id": "widget_ghi789",
     *               "type": "text",
     *               "data": { "content": "<p>Hello</p>" }
     *             }
     *           ]
     *         }
     *       ]
     *     }
     *   ]
     * }
     */

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    protected static function newFactory()
    {
        return \Crumbls\Layup\Database\Factories\PageFactory::new();
    }
}
