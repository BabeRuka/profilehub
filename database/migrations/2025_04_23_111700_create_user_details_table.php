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
        Schema::create('user_details', function (Blueprint $table) {
            $table->integer('details_id', true);
            $table->unsignedBigInteger('user_id')->unique('user_id');
            $table->string('username')->nullable()->unique('username');
            $table->string('firstname')->nullable()->index('firstname');
            $table->string('lastname')->nullable()->index('lastname');
            $table->string('middle_name')->nullable()->index('middle_name');
            $table->string('user_bio', 255)->nullable();
            $table->index('user_bio', null, null, null, 191); 
            $table->string('profile_pic')->nullable()->index('profile_pic');
            $table->string('user_avatar')->nullable()->index('user_avatar');
            $table->dateTime('create_date');
            $table->timestamp('modified_date')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
