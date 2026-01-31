<?php

namespace DagaSmart\Knowledge\Models;

use DagaSmart\bizAdmin\Models\AdminUser;

use Illuminate\Database\Eloquent\SoftDeletes;

class KnowledgeScene extends Model
{
    use SoftDeletes;

    /**
     * 表名
     */
    protected $table = 'wiki_knowledge_scenes';

    /**
     * 批量赋值白名单
     * extra 字段自动 cast 成数组
     */
    protected $fillable = [
        'company_id',
        'author_id',
        'code',
        'name',
        'description',
        'status',
        'priority',
        'extra',
    ];

    /**
     * 类型转换
     * extra 是 JSON 格式
     */
    protected $casts = [
        'extra' => 'array',
        'status' => 'integer',
        'priority' => 'integer',
    ];

    /**
     * 模型启动时自动应用全局作用域
     * 让所有查询默认按当前租户 company_id 过滤
     */
    protected static function booted(): void
    {

        // 创建时自动填充 author_id 和 company_id
        static::creating(function ($model) {
            $user = admin_user();

            // 如果模型没有设置 company_id，则使用当前用户的 company_id
            if (empty($model->company_id) && isset($user->company_id)) {
                $model->company_id = $user->company_id;
            }

            // 记录创建作者
            $model->author_id = $user->id;
        });
    }

    /**
     * 关闭全局 company 过滤器（如果需要管理端查看全部）
     */
    public static function withoutTenantScope()
    {
        return static::withoutGlobalScope('company');
    }

    /**
     * 关联创建者（作者用户）
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'author_id', 'id');
    }

    /**
     * 判断当前场景是否启用
     */
    public function isEnabled(): bool
    {
        return (int)$this->status === 1;
    }

    /**
     * 设置 extra 某个键
     */
    public function setExtraKey(string $key, $value): self
    {
        $extra = $this->extra ?? [];
        $extra[$key] = $value;
        $this->extra = $extra;

        return $this;
    }

    /**
     * 获取 extra 的值（带默认）
     */
    public function getExtra(string $key, $default = null)
    {
        return $this->extra[$key] ?? $default;
    }


}
