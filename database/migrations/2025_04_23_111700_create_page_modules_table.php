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
            $table->unsignedInteger('module_id', true);
            $table->primary('module_id');
            $table->unsignedInteger('page_id')->nullable();
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('setting_id')->nullable();
            $table->enum('has_widget', ['0', '1', '2'])->nullable()->default('2');
            $table->integer('widget_order')->nullable();
            $table->enum('widget_type', ['public', 'admin', 'user', 'profile'])->nullable()->default('user');
            $table->string('module_name')->nullable();
            $table->string('module_slug')->nullable();
            $table->string('module_icon')->nullable();
            $table->string('module_desc')->nullable();
            $table->string('module_active')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->dateTime('create_date')->nullable();

            // foreign keys
            $table->foreign('page_id')->references('page_id')->on('pages')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('group_id')->references('group_id')->on('page_module_groups')->onDelete('RESTRICT')->onUpdate('RESTRICT');
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
