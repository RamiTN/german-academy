<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('teachers') && !Schema::hasColumn('teachers', 'slug')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('slug')->unique()->nullable()->after('user_id');
            });
        }

        if (Schema::hasTable('class_groups') && !Schema::hasColumn('class_groups', 'slug')) {
            Schema::table('class_groups', function (Blueprint $table) {
                $table->string('slug')->unique()->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('teachers') && Schema::hasColumn('teachers', 'slug')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }

        if (Schema::hasTable('class_groups') && Schema::hasColumn('class_groups', 'slug')) {
            Schema::table('class_groups', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
