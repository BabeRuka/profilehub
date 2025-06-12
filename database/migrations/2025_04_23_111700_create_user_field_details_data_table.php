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
        Schema::create('user_field_details_data', function (Blueprint $table) {
            $table->integer('data_id', true);
            $table->integer('field_id')->index('field_id');
            $table->integer('son_id')->index('son_id');
            $table->integer('user_id')->index('user_id');
            $table->text('user_entry')->nullable()->fulltext('user_entry');
            $table->integer('user_rows')->nullable();
            $table->text('details_data')->nullable();
            $table->integer('sequence')->nullable()->index('sequence');
            $table->dateTime('create_date');
            $table->timestamp('modified_date')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_field_details_data');
    }
};
