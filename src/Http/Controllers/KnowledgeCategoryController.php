<?php

namespace DagaSmart\Knowledge\Http\Controllers;

use DagaSmart\Knowledge\Enums\KnowledgeVisibility;
use DagaSmart\Knowledge\Services\KnowledgeCategoryService;


class KnowledgeCategoryController extends AdminController
{
    /**
     * 绑定 Service
     */
    protected string $serviceName = KnowledgeCategoryService::class;

    /**
     * 列表
     */
    public function list()
    {
        $crud = $this->baseCRUD()
            ->filterTogglable(false)
            ->headerToolbar([
                $this->createButton('dialog'),
                ...$this->baseHeaderToolBar(),
            ])
            ->columns([
                amis()->TableColumn('id', 'ID')
                    ->sortable()
                    ->width(80),

                amis()->TableColumn('name', '分类名称')
                    ->searchable()
                    ->ellipsis(),

                amis()->TableColumn('code', '分类标识')
                    ->copyable()
                    ->ellipsis(),

                amis()->TableColumn('priority', '优先级')
                    ->sortable()
                    ->quickEdit(
                        amis()->NumberControl()->min(0)
                    ),

                amis()->TableColumn('status', '状态')
                    ->type('status')
                    ->map([
                        1 => 'success',
                        0 => 'warning',
                    ])
                    ->labelMap([
                        1 => '启用',
                        0 => '停用',
                    ])
                    ->quickEdit(
                        amis()->SwitchControl()
                            ->onText('启用')
                            ->offText('停用')
                    ),

                amis()->TableColumn('created_at', '创建时间')
                    ->type('datetime')
                    ->sortable(),

                $this->rowActions('dialog'),
            ]);

        return $this->baseList($crud);
    }

    /**
     * 表单
     */
    public function form($isEdit = false)
    {
        return $this->baseForm()->body([
            amis()->TextControl('name', '分类名称')
                ->required()
                ->maxLength(50)
                ->placeholder('如：销售知识库 / 活动知识库'),

            amis()->TextControl('code', '分类标识')
                ->required()
                ->maxLength(50)
                ->description('程序使用的唯一标识，建议英文小写，如 sales / activity'),

            amis()->SelectControl('visibility', '可见性')
                ->required()
                ->options(KnowledgeVisibility::options())
                ->value('public')
                ->description('控制该知识的可见范围：公开（所有人）、私有（仅自己）'),

            amis()->NumberControl('priority', '优先级')
                ->value(100)
                ->min(0)
                ->description('数值越小，排序越靠前'),

            amis()->SwitchControl('status', '状态')
                ->value(1)
                ->onText('启用')
                ->offText('停用'),
        ]);
    }

    /**
     * 详情
     */
    public function detail()
    {
        return $this->baseDetail()->body([
            amis()->TextControl('id', 'ID')->static(),
            amis()->TextControl('name', '分类名称')->static(),
            amis()->TextControl('code', '分类标识')->static(),
            amis()->TextControl('priority', '优先级')->static(),
            amis()->StaticExactControl('status', '状态')
                ->type('static-status')
                ->map([
                    1 => 'success',
                    0 => 'danger',
                ])
                ->labelMap([
                    1 => '启用',
                    0 => '停用',
                ]),
            amis()->TextControl('created_at', '创建时间')->static(),
            amis()->TextControl('updated_at', '更新时间')->static(),
        ]);
    }
}
