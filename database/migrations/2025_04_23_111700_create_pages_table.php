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
        Schema::create('pages', function (Blueprint $table) {
            $table->integer('page_id')->primary();
            $table->string('page_slug')->nullable();
            $table->string('page_name');
            $table->string('page_title')->nullable();
            $table->string('page_tags')->nullable();
            $table->integer('page_type')->nullable();
            $table->integer('page_admin')->nullable();
            $table->string('page_desc')->nullable();
            $table->text('page_content')->nullable();
            $table->string('linked_page')->nullable();
            $table->string('page_settings')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
