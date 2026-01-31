<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


return new class extends Migration
{
    protected $connection = 'bus';
    private string $table = 'wiki_knowledge_categories';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            if (!Schema::hasTable($this->table)) {
                //创建表
                Schema::create($this->table, function (Blueprint $table) {
                $table->id();

                $table->string('name', 50)
                    ->comment('分类名称');

                $table->string('code', 50)
                    ->unique()
                    ->comment('分类标识');

                $table->unsignedInteger('priority')
                    ->default(100)
                    ->comment('优先级，数值越小权重越高');

                $table->boolean('status')
                    ->default(1)
                    ->comment('状态：1 启用 0 停用');

                $table->timestamps();
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
