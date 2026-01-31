<?php

namespace DagaSmart\Knowledge\Enums;

class KnowledgeSource
{
    public const TRAINING   = '培训资料';
    public const SALES_MANUAL = '销售手册';
    public const SUPPORT_MANUAL = '客服手册';
    public const PRODUCT_MANUAL = '产品手册';
    public const ACTIVITY_DOC = '活动文档';

    /**
     * 获取下拉选项
     */
    public static function options(): array
    {
        return [
            self::TRAINING        => '培训资料',
            self::SALES_MANUAL    => '销售手册',
            self::SUPPORT_MANUAL  => '客服手册',
            self::PRODUCT_MANUAL  => '产品手册',
            self::ACTIVITY_DOC    => '活动文档',
        ];
    }
}
