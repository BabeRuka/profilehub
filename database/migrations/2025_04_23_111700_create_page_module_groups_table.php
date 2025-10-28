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
        Schema::create('page_module_groups', function (Blueprint $table) {
            $table->integer('group_id', true);
            $table->integer('setting_id')->nullable();
            $table->string('group_name');
            $table->string('goup_slug');
            $table->string('group_icon')->nullable();
            $table->string('group_desc')->nullable();
            $table->string('group_active')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('create_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_module_groups');
    }
};
