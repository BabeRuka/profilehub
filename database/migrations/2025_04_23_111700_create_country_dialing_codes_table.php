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
        Schema::create('country_dialing_codes', function (Blueprint $table) {
            $table->integer('country_id');
            $table->text('country_desc')->nullable();
            $table->string('country_code')->nullable();
            $table->string('dialing_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_dialing_codes');
    }
};
