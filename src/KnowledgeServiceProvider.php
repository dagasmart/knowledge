<?php

namespace DagaSmart\Knowledge;

use DagaSmart\bizAdmin\Renderers\TextControl;
use DagaSmart\bizAdmin\Extend\ServiceProvider;

class KnowledgeServiceProvider extends ServiceProvider
{

    /**
     * 扩展后台菜单
     */
    protected $menu = [
        [
            'title'    => '知识库',
            'url'      => '/knowledge',
            'url_type' => 1,
            'icon'     => 'arcticons:bookshelf',
        ],
        [
            'parent'   => '知识库',
            'title'    => '知识内容',
            'url'      => '/knowledge/items',
            'url_type' => 1,
            'icon'     => 'arcticons:folder-book',
        ],
        [
            'parent'   => '知识库',
            'title'    => '知识分类',
            'url'      => '/knowledge/categories',
            'url_type' => 1,
            'icon'     => 'arcticons:bookcatalogue',
        ],
        [
            'parent'   => '知识库',
            'title'    => '使用场景',
            'url'      => '/knowledge/scenes',
            'url_type' => 1,
            'icon'     => 'arcticons:google-play-books',
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        // 加载扩展 migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // 加载扩展后台路由（admin-api）
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }
}
