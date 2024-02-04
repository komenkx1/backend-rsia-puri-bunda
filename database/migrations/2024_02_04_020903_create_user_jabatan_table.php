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
        Schema::create('user_jabatan', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer("user_id");
            $table->integer("jabatan_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_jabatan');
    }
};
