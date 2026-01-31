<?php

namespace DagaSmart\Knowledge\Http\Controllers;

use DagaSmart\Knowledge\Services\KnowledgeSceneService;


class KnowledgeSceneController extends AdminController
{
    /**
     * 绑定 Service
     */
    protected string $serviceName = KnowledgeSceneService::class;

    /**
     * 列表页面结构
     */
    public function list()
    {
        $crud = $this->baseCRUD()
            // 是否显示筛选折叠按钮
            ->filterTogglable(false)
            // 头部工具栏：新增按钮 + 框架默认按钮
            ->headerToolbar([
                $this->createButton('drawer'),
                ...$this->baseHeaderToolBar(),
            ])
            // 表格列定义
            ->columns([
                amis()->TableColumn('id', 'ID')
                    ->sortable()
                    ->width(80),

                amis()->TableColumn('code', '场景编码')
                    ->searchable()
                    ->ellipsis(),

                amis()->TableColumn('name', '场景名称')
                    ->searchable()
                    ->ellipsis(),

                amis()->TableColumn('description', '描述')
                    ->ellipsis(),

                amis()->TableColumn('status', '状态')
                    ->type('status')
                    ->map([1 => 'success', 0 => 'warning'])
                    ->labelMap([1 => '启用', 0 => '停用']),

                // 优先级
                amis()->TableColumn('priority', '优先级')
                    ->sortable(),

                // 创建者
                amis()->TableColumn('author.name', '作者'),

                // 创建时间
                amis()->TableColumn('created_at', '创建时间')
                    ->type('datetime')
                    ->sortable(),

                $this->rowActions('drawer'),
            ]);

        return $this->baseList($crud);
    }

    /**
     * 表单结构（新增/编辑）
     *
     */
    public function form($isEdit = false)
    {
        return $this->baseForm()->body([
            // 场景编码（唯一、小写字母/数字/下划线）
            amis()->TextControl('code', '场景编码')
                ->required()
                ->maxLength(50)
                ->placeholder('请输入唯一编码，如 first_chat'),

            // 场景名称
            amis()->TextControl('name', '场景名称')
                ->required()
                ->maxLength(100)
                ->placeholder('请输入显示名称'),

            // 描述信息
            amis()->TextareaControl('description', '描述')
                ->description('可选：对该场景的用途做简要说明'),

            // 状态开关
            amis()->SwitchControl('status', '状态')
                ->value(1)
                ->onText('启用')
                ->offText('停用')
                ->description('是否启用该场景'),

            // 优先级数值
            amis()->NumberControl('priority', '优先级')
                ->value(100)
                ->min(0)
                ->description('用于排序显示，数值越小越靠前'),
        ]);
    }

    /**
     * 详情页结构
     *
     * @param mixed $id
     */
    public function detail($id)
    {
        return $this->baseDetail()->body([
            amis()->TextControl('id', 'ID')->static(),
            amis()->TextControl('code', '场景编码')->static(),
            amis()->TextControl('name', '场景名称')->static(),
            amis()->TextControl('description', '描述')->static(),
            amis()->TextControl('priority', '优先级')->static(),

            // 状态显示
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

            // 作者 ID
            amis()->TextControl('author_id', '作者ID')->static(),

            // 创建/更新时间
            amis()->TextControl('created_at', '创建时间')->static(),
            amis()->TextControl('updated_at', '更新时间')->static(),
        ]);
    }

    /**
     * 删除数据（软删除）
     */
    public function destroy($id)
    {
        return $this->response()->success(
            $this->service->delete($id)
        );
    }
}
