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
        Schema::table('user_field', function (Blueprint $table) {
            // user_field.group_id -> user_field_groups.group_id
            if (!Schema::hasColumn('user_field', 'group_id')) return;
            $table->foreign('group_id', 'uf_group_id')->references('group_id')->on('user_field_groups')->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::table('user_field_son', function (Blueprint $table) {
            // user_field_son.field_id -> user_field.field_id
            if (!Schema::hasColumn('user_field_son', 'field_id')) return;
            $table->foreign('field_id', 'field_id')->references('field_id')->on('user_field')->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::table('user_field_details', function (Blueprint $table) {
            if (Schema::hasColumn('user_field_details', 'field_id')) {
                $table->foreign('field_id', 'ufd_field_id')->references('field_id')->on('user_field')->onDelete('restrict')->onUpdate('restrict');
            }
            if (Schema::hasColumn('user_field_details', 'user_id')) {
                $table->foreign('user_id', 'ufd_user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            }
        });

        Schema::table('user_field_details_data', function (Blueprint $table) {
            if (Schema::hasColumn('user_field_details_data', 'field_id')) {
                $table->foreign('field_id', 'ufdd_field_id')->references('field_id')->on('user_field')->onDelete('restrict')->onUpdate('restrict');
            }
            if (Schema::hasColumn('user_field_details_data', 'son_id')) {
                $table->foreign('son_id', 'ufdd_son_id')->references('son_id')->on('user_field_son')->onDelete('restrict')->onUpdate('restrict');
            }
            if (Schema::hasColumn('user_field_details_data', 'user_id')) {
                $table->foreign('user_id', 'ufdd_user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            }
        });

        Schema::table('user_group_users', function (Blueprint $table) {
            if (Schema::hasColumn('user_group_users', 'group_id')) {
                $table->foreign('group_id', 'group_id')->references('group_id')->on('user_groups')->onDelete('restrict')->onUpdate('restrict');
            }
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('user_profiles', 'user_id')) {
                $table->foreign('user_id', 'up_user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_field', function (Blueprint $table) {
            $table->dropForeign('uf_group_id');
        });
        Schema::table('user_field_son', function (Blueprint $table) {
            $table->dropForeign('field_id');
        });
        Schema::table('user_field_details', function (Blueprint $table) {
            $table->dropForeign('ufd_field_id');
            $table->dropForeign('ufd_user_id');
        });
        Schema::table('user_field_details_data', function (Blueprint $table) {
            $table->dropForeign('ufdd_field_id');
            $table->dropForeign('ufdd_son_id');
            $table->dropForeign('ufdd_user_id');
        });
        Schema::table('user_group_users', function (Blueprint $table) {
            $table->dropForeign('group_id');
        });
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign('up_user_id');
        });
    }
};
