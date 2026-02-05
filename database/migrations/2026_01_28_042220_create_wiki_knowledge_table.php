<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{
    protected $connection = null;
    private string $table = 'wiki_knowledge';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->table)) {
            //创建表
            Schema::create($this->table, function (Blueprint $table) {
                $table->comment('知识库-内容表');
                $table->id();

                $table->string('title', 100)->comment('知识标题');
                $table->string('category_code', 50)->comment('分类 code');
                $table->string('scene', 50)->nullable()->comment('使用场景，如 sales / support');
                $table->text('content')->comment('知识内容');

                $table->json('metadata')->nullable()->comment('扩展元数据（标签 / 来源 / 备注）');
                $table->string('visibility', 32)->default('public')->comment('可见性: public=公开, internal=内部可见, private=私有');
                $table->Integer('company_id')->nullable()->comment('所属公司/租户 ID');
                $table->Integer('author_id')->nullable()->comment('创建者用户 ID');

                $table->integer('priority')->default(100)->comment('优先级，越小越优先');
                $table->tinyInteger('status')->default(1)->comment('状态 1启用 0停用');

                $table->timestamps();
                $table->softDeletes();

                $table->index(['category_code', 'scene', 'status']);
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
