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
        if (! Schema::hasTable('page_data')) {
            Schema::create('page_data', function (Blueprint $table) {
                $table->unsignedInteger('data_id', true);
                $table->primary('data_id');
                $table->unsignedInteger('page_id');
                $table->string('page_key')->nullable();
                $table->string('page_module')->nullable();
                $table->integer('page_sequence')->nullable();
                $table->text('page_data')->nullable();
                $table->dateTime('create_date')->nullable();
                $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();

                // foreign keys
                $table->foreign('page_id')->references('page_id')->on('pages')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_data');
    }
};
