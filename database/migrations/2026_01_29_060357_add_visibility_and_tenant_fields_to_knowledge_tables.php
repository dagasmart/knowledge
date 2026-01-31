<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 修改 knowledge_categories 表
        Schema::table('wiki_knowledge_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('wiki_knowledge_categories', 'visibility')) {
                $table->string('visibility', 32)
                    ->default('public')
                    ->comment('可见性: public=公开, internal=内部可见, private=私有')
                    ->after('code');
            }

            if (!Schema::hasColumn('wiki_knowledge_categories', 'company_id')) {
                $table->unsignedBigInteger('company_id')
                    ->nullable()
                    ->comment('所属公司/租户 ID')
                    ->after('visibility');
            }

            if (!Schema::hasColumn('wiki_knowledge_categories', 'author_id')) {
                $table->unsignedBigInteger('author_id')
                    ->nullable()
                    ->comment('创建者用户 ID')
                    ->after('company_id');
            }
        });

        // 修改 knowledge 表
        Schema::table('wiki_knowledge', function (Blueprint $table) {
            if (!Schema::hasColumn('wiki_knowledge', 'visibility')) {
                $table->string('visibility', 32)
                    ->default('public')
                    ->comment('可见性: public=公开, internal=内部可见, private=私有')
                    ->after('metadata');
            }

            if (!Schema::hasColumn('wiki_knowledge', 'company_id')) {
                $table->unsignedBigInteger('company_id')
                    ->nullable()
                    ->comment('所属公司/租户 ID')
                    ->after('visibility');
            }

            if (!Schema::hasColumn('wiki_knowledge', 'author_id')) {
                $table->unsignedBigInteger('author_id')
                    ->nullable()
                    ->comment('创建者用户 ID')
                    ->after('company_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wiki_knowledge_categories', function (Blueprint $table) {
            $table->dropColumn(['visibility', 'company_id', 'author_id']);
        });

        Schema::table('wiki_knowledge', function (Blueprint $table) {
            $table->dropColumn(['visibility', 'company_id', 'author_id']);
        });
    }
};
