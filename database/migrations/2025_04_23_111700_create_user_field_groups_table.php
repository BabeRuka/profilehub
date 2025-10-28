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
        Schema::create('user_field_groups', function (Blueprint $table) {
            $table->integer('group_id', true);
            $table->string('type_group')->nullable()->index('type_group');
            $table->string('group_icon')->nullable()->index('group_icon');
            $table->string('group_name')->default('')->index('group_name');
            $table->integer('sequence')->nullable()->default(0);
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_field_groups');
    }
};
