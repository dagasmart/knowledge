<?php

namespace DagaSmart\Knowledge\Enums;

class KnowledgeMetaKey
{
    // 标签系统
    public const TAGS = 'tags';

    // AI 行为控制
    public const AI_ENABLED = 'ai_enabled';
    public const CONFIDENCE = 'confidence';
    public const MAX_TOKENS = 'max_tokens';

    // 来源 / 备注
    public const SOURCE = 'source';
    public const REMARK = 'remark';

    /**
     * 所有允许的 key
     */
    public static function keys(): array
    {
        return [
            self::TAGS,
            self::AI_ENABLED,
            self::CONFIDENCE,
            self::MAX_TOKENS,
            self::SOURCE,
            self::REMARK,
        ];
    }

    /**
     * key 描述（后台 / 文档用）
     */
    public static function descriptions(): array
    {
        return [
            self::TAGS => '标签数组，如 ["高转化","新手可用"]',
            self::AI_ENABLED => '是否允许 AI 使用',
            self::CONFIDENCE => '知识可信度 0~1',
            self::MAX_TOKENS => 'AI 最大可用 token',
            self::SOURCE => '知识来源',
            self::REMARK => '内部备注',
        ];
    }

    public static function labels(): array
    {
        return [
            self::TAGS => '标签',
            self::AI_ENABLED => '允许AI使用',
            self::CONFIDENCE => '知识可信度',
            self::MAX_TOKENS => 'AI最大token',
            self::SOURCE => '来源',
            self::REMARK => '备注',
        ];
    }
}
