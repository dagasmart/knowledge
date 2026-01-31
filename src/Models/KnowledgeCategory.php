<?php
namespace DagaSmart\Knowledge\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class KnowledgeCategory extends Model
{
    use SoftDeletes;

    protected $table = 'wiki_knowledge_categories';

    protected $fillable = [
        'name',
        'code',
        'status',
        'priority',
    ];
}
