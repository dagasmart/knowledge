<?php
namespace DagaSmart\Knowledge\Services;

use DagaSmart\Knowledge\Models\KnowledgeCategory;

use DagaSmart\Knowledge\Models\Knowledge;

class KnowledgeService extends AdminService
{
    protected string $modelName = Knowledge::class;

    /**
     * 保存前处理（官方 saving 钩子）
     */
    public function saving(&$data, $primaryKey = ''): void
    {
        $data['scene'] = isset($data['scene'])
            ? strtolower(trim($data['scene']))
            : null;

        $data['priority'] ??= 100;

        // 处理 metadata 多控件组合
        $metadata = [
            'tags'        => $data['metadata_tags'] ?? [],
            'ai_enabled'  => $data['metadata_ai_enabled'] ?? 0,
            'confidence'  => $data['metadata_confidence'] ?? 0.9,
            'max_tokens'  => $data['metadata_max_tokens'] ?? 500,
            'source'      => $data['metadata_source'] ?? '',
            'remark'      => $data['metadata_remark'] ?? '',
        ];

        $data['metadata'] = json_encode($metadata, JSON_UNESCAPED_UNICODE);

        // 删除临时字段
        unset(
            $data['metadata_tags'],
            $data['metadata_ai_enabled'],
            $data['metadata_confidence'],
            $data['metadata_max_tokens'],
            $data['metadata_source'],
            $data['metadata_remark']
        );

        $this->validateData($data, $primaryKey);
    }

    /**
     * 数据校验
     */
    private function validateData($data, $primaryKey = ''): void
    {
        if (array_key_exists('title', $data) && empty($data['title'])) {
            admin_abort('知识标题不能为空');
        }

        if (array_key_exists('category_code', $data) && empty($data['category_code'])) {
            admin_abort('必须选择知识分类');
        }

        if (array_key_exists('content', $data) && empty($data['content'])) {
            admin_abort('知识内容不能为空');
        }

        if (array_key_exists('scene', $data) && !empty($data['scene'])) {
            if (!preg_match('/^[a-z0-9_]+$/', $data['scene'])) {
                admin_abort('scene 只能包含小写字母、数字和下划线');
            }
        }
    }
}
