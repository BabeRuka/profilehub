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
        Schema::create('country_codes', function (Blueprint $table) {
            $table->integer('country_id');
            $table->string('country_code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_currency_symbol')->nullable();
            $table->string('country_currency_code')->nullable();
            $table->string('country_currency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_codes');
    }
};
