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
        Schema::create('page_widgets', function (Blueprint $table) {
            $table->integer('widget_id')->primary();
            $table->integer('page_id');
            $table->string('page_key')->nullable();
            $table->string('widget_key')->nullable();
            $table->string('widget_value')->nullable();
            $table->enum('widget_active', ['0', '1', '2'])->nullable()->default('0');
            $table->integer('widget_order')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_widgets');
    }
};
