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
        Schema::create('country_states', function (Blueprint $table) {
            $table->integer('state_id')->primary();
            $table->integer('country_id')->nullable();
            $table->string('state_name')->nullable();
            $table->string('state_code')->nullable();
            $table->string('state_capital')->nullable();
            $table->string('state_region')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_states');
    }
};
