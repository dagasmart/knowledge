<?php

namespace DagaSmart\Knowledge\Enums;

class KnowledgeMetaTags
{
    public const HIGH_CONVERSION = '高转化';
    public const NEW_USER = '新手可用';
    public const STANDARD_PROCESS = '标准流程';
    public const ACTIVITY = '活动';
    public const KEY_POINT = '重点';
    public const IMPORTANT_CLIENT = '重要客户';
    public const AFTER_SALES = '售后处理';
    public const INTERNAL_TRAINING = '内部培训';

    /**
     * 返回所有标签选项
     */
    public static function options(): array
    {
        return [
            self::HIGH_CONVERSION => '高转化',
            self::NEW_USER => '新手可用',
            self::STANDARD_PROCESS => '标准流程',
            self::ACTIVITY => '活动',
            self::KEY_POINT => '重点',
            self::IMPORTANT_CLIENT => '重要客户',
            self::AFTER_SALES => '售后处理',
            self::INTERNAL_TRAINING => '内部培训',
        ];
    }
}
