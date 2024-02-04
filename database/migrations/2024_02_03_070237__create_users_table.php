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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer("unit_id")->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->date('join_date');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
