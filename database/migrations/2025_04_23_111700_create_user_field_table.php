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
        Schema::create('user_field', function (Blueprint $table) {
            $table->integer('field_id', true);
            $table->integer('id_details')->nullable()->default(0)->index('id_common');
            $table->integer('group_id')->nullable()->index('group_id');
            $table->string('type_field')->nullable()->index('type_field');
            $table->string('lang_code')->nullable()->default('eng');
            $table->string('translation')->default('')->index('translation');
            $table->integer('sequence')->nullable()->default(0);
            $table->integer('group_sequence')->nullable();
            $table->string('show_on_platform')->nullable()->default('framework,');
            $table->boolean('use_multilang')->nullable()->default(false);
            $table->dateTime('create_date')->nullable();
            $table->timestamp('modified_date')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_field');
    }
};
