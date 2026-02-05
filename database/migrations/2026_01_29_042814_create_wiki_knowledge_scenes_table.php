<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{
    protected $connection = null;
    private string $table = 'wiki_knowledge_scenes';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            //创建表
            Schema::create($this->table, function (Blueprint $table) {
                $table->comment('知识库-场景表');
                $table->id();

                // 所属公司/租户
                $table->foreignId('company_id')
                    ->nullable()
                    ->comment('所属公司/租户 ID');

                // 创建者（作者）ID
                $table->foreignId('author_id')
                    ->nullable()
                    ->comment('创建者/作者 用户 ID');

                // 唯一编码，例如 first_chat、objection 等
                $table->string('code', 64)
                    ->unique()
                    ->comment('唯一编码');

                // 场景名称
                $table->string('name', 128)->comment('场景显示名称');

                // 备注/说明
                $table->string('description', 255)
                    ->nullable()
                    ->comment('场景描述/备注');

                // 启用状态
                $table->tinyInteger('status')
                    ->default(1)
                    ->comment('启用状态 (1=启用,0=停用)');

                // 排序优先级
                $table->integer('priority')
                    ->default(100)
                    ->comment('排序优先级');

                // 扩展字段 JSON
                $table->json('extra')
                    ->nullable()
                    ->comment('扩展 JSON 配置');

                // 时间戳：创建/更新时间
                $table->timestamps();

                // 软删除字段
                $table->softDeletes();
            });
        }
    }


    /**
     * 迁移回滚
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable($this->table)) {
            //检查是否存在数据
            $exists = DB::table($this->table)->exists();
            //不存在数据时，删除表
            if (!$exists) {
                //删除 reverse
                Schema::dropIfExists($this->table);
            }
        }
    }

};
