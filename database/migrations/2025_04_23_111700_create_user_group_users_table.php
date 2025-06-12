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
        Schema::create('user_group_users', function (Blueprint $table) {
            $table->integer('user_group_id', true);
            $table->integer('group_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_group_users');
    }
};
