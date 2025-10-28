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
        Schema::create('page_modules', function (Blueprint $table) {
            $table->integer('module_id', true);
            $table->integer('page_id')->nullable();
            $table->integer('group_id');
            $table->integer('setting_id')->nullable();
            $table->enum('has_widget', ['0', '1', '2'])->nullable()->default('2');
            $table->integer('widget_order')->nullable();
            $table->enum('widget_type', ['public', 'admin', 'user', 'profile'])->nullable()->default('user');
            $table->string('module_name')->nullable();
            $table->string('mudule_slug')->nullable();
            $table->string('module_icon')->nullable();
            $table->string('module_desc')->nullable();
            $table->string('module_active')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('create_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_modules');
    }
};
