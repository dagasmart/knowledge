<?php

namespace DagaSmart\Knowledge\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Knowledge extends Model
{
    use SoftDeletes;

    protected $table = 'wiki_knowledge';

    protected $fillable = [
        'title',
        'category_code',
        'scene',
        'content',
        'priority',
        'status',
        'metadata',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
