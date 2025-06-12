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
        Schema::create('user_field_son_data', function (Blueprint $table) {
            $table->integer('data_id', true);
            $table->integer('son_id')->default(0)->index('field_id');
            $table->string('data_key')->nullable();
            $table->string('data_value')->nullable();
            $table->text('data')->nullable();
            $table->string('data_sequence')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_field_son_data');
    }
};
