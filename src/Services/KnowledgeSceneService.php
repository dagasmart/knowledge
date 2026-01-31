<?php

namespace DagaSmart\Knowledge\Services;

use DagaSmart\Knowledge\Models\KnowledgeScene;

use Illuminate\Support\Facades\Auth;

class KnowledgeSceneService extends AdminService
{
    /**
     * 关联模型
     */
    protected string $modelName = KnowledgeScene::class;

    /**
     * 列表查询处理。
     *
     */
    public function listQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // 从 AdminService 继承来的基础查询
        $query = $this->query()->with('author');

        // 多租户过滤：仅显示当前租户的数据
        if ($user = Auth::user()) {
            $query->where('company_id', $user->company_id);
        }

        // 按 code 模糊搜索
        if ($code = request('code')) {
            $query->where('code', 'like', "%{$code}%");
        }

        // 按 name 模糊搜索
        if ($name = request('name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        // 按状态过滤
        if (!is_null(request('status'))) {
            $query->where('status', request('status'));
        }

        return $query;
    }

    /**
     * 保存前处理
     *
     */
    public function saving(&$data, $primaryKey = ''): void
    {
        // code 统一转小写
        if (isset($data['code'])) {
            $data['code'] = strtolower(trim($data['code']));
        }

        // 创建时如果没有 company_id，则填充当前用户 company_id
        if (Auth::check()) {
            $user = Auth::user();
            if (empty($data['company_id']) && isset($user->company_id)) {
                $data['company_id'] = $user->company_id;
            }
        }

        $this->validateData($data, $primaryKey);
    }

    /**
     * 数据校验
     */
    private function validateData(array $data, $primaryKey = ''): void
    {
        // 必填检查
        if (empty($data['code'])) {
            admin_abort('场景编码（code）不能为空');
        }

        if (!preg_match('/^[a-z0-9_]+$/', $data['code'])) {
            admin_abort('编码只能包含小写字母、数字和下划线');
        }

        if (empty($data['name'])) {
            admin_abort('场景名称不能为空');
        }

        // 唯一性检查（code 唯一）
        $exists = KnowledgeScene::withoutGlobalScope('company')
            ->where('code', $data['code'])
            ->when($primaryKey, fn($q) => $q->where('id', '<>', $primaryKey))
            ->exists();

        if ($exists) {
            admin_abort('编码已存在，请换一个');
        }
    }

    public static function getOptionList(): array
    {
        return KnowledgeScene::query()
            ->where('status', 1)
            ->orderBy('priority')
            ->pluck('name', 'code')
            ->toArray();
    }
}
