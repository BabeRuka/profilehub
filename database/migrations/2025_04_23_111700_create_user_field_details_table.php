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
        Schema::create('user_field_details', function (Blueprint $table) {
            $table->integer('details_id', true);
            $table->integer('field_id')->index('field_id');
            $table->integer('son_id')->nullable();
            $table->integer('user_id')->default(0)->index('user_id');
            $table->text('user_entry')->nullable()->fulltext('user_entry');
            $table->text('details_data')->nullable();
            $table->dateTime('create_date');
            $table->timestamp('modified_date')->useCurrentOnUpdate()->useCurrent();

            $table->unique(['field_id', 'user_id'], 'field_id_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_field_details');
    }
};
