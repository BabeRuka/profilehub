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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->integer('profile_id', true);
            $table->integer('user_id')->nullable()->index('user_id');
            $table->enum('pforce', ['1', '0'])->default('0')->index('pforce');
            $table->string('num_rows')->nullable()->index('num_rows');
            $table->string('num_filled')->nullable()->index('num_filled');
            $table->dateTime('create_date')->nullable();
            $table->dateTime('modified_date')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
