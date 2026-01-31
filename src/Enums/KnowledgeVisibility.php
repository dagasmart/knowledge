<?php

namespace DagaSmart\Knowledge\Enums;

enum KnowledgeVisibility
{
    public const PUBLIC = 'public';
    public const INTERNAL = 'internal';
    public const PRIVATE = 'private';

    /**
     * 获取可读标签
     */
    public static function options(): array
    {
        return [
            self::PUBLIC   => '公开',
//            self::INTERNAL => '内部',
            self::PRIVATE  => '私有',
        ];
    }
}
