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
        Schema::create('user_field_son', function (Blueprint $table) {
            $table->integer('son_id', true);
            $table->integer('field_id')->default(0)->index('field_id');
            $table->string('lang_code', 50)->nullable()->default('');
            $table->string('translation')->default('');
            $table->enum('field_type', ['text', 'data', 'json', 'number', 'string', 'dropdown', 'date', 'widget'])->default('text');
            $table->string('field_settings')->nullable();
            $table->integer('sequence')->nullable()->default(0);
            $table->text('data')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_field_son');
    }
};
