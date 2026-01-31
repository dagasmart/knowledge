<?php

namespace DagaSmart\Knowledge\Services;

use DagaSmart\Knowledge\Models\KnowledgeCategory;


class KnowledgeCategoryService extends AdminService
{
    protected string $modelName = KnowledgeCategory::class;

    /**
     * 保存前统一处理数据
     */
    public function saving(&$data, $primaryKey = ''): void
    {
        // code 统一小写
        if (!empty($data['code'])) {
            $data['code'] = strtolower(trim($data['code']));
        }

        // priority 兜底
        if (!isset($data['priority'])) {
            $data['priority'] = 100;
        }

        $this->validateData($data, $primaryKey);
    }

    /**
     * 数据验证
     */
    private function validateData($data, $primaryKey = ''): void
    {
        /**
         * name 校验
         */
        if (array_key_exists('name', $data)) {
            if (empty($data['name'])) {
                admin_abort('分类名称不能为空');
            }
        }

        /**
         * code 校验
         */
        if (array_key_exists('code', $data)) {
            if (empty($data['code'])) {
                admin_abort('分类标识 code 不能为空');
            }

            // code 格式校验
            if (!preg_match('/^[a-z0-9_]+$/', $data['code'])) {
                admin_abort('分类标识 code 只能包含小写字母、数字和下划线');
            }

            // code 唯一性校验
            $query = KnowledgeCategory::withTrashed()
                ->where('code', $data['code']);

            if ($primaryKey) {
                $query->where('id', '!=', $primaryKey);
            }

            if ($query->exists()) {
                admin_abort('分类标识 code 已存在，请使用唯一值');
            }
        }
    }

    /**
     * 提供给 业务侧的可用分类列表
     * - 仅启用
     * - 排除软删除
     * - 按优先级排序
     */
    public function getEnabledList(): array
    {
        return KnowledgeCategory::query()
            ->where('status', 1)
            ->orderBy('priority')
            ->orderBy('id')
            ->get([
                'id',
                'name',
                'code',
                'priority',
            ])
            ->toArray();
    }

    /**
     * 提供给 Prompt / 下拉选择的键值对
     */
    public static function getOptionList(): array
    {
        return KnowledgeCategory::query()
            ->where('status', 1)
            ->orderBy('priority')
            ->pluck('name', 'code')
            ->toArray();
    }

    public static function getNavList(): array
    {
        return KnowledgeCategory::query()
            ->where('status', 1)
            ->orderBy('priority')
            ->get(['code', 'name'])
            ->map(function ($category) {
                return [
                    'label' => $category->name,
                    'value' => $category->code,
                    'to'    => '/knowledge/items?category_code=' . $category->code.'&category_name=' . $category->name,
                ];
            })
            ->toArray();
    }
}
