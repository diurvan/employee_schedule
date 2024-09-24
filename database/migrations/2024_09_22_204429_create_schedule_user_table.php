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
        Schema::create('schedule_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->date('schedule_date');
            $table->timestamps();

            $table->index(['id_user', 'schedule_date']);
            $table->unique(['id_user','schedule_date']);

            $table->foreign('id_user', 'fk_schedule_user')->references('id')->on('users');
        });
        Schema::create('schedule_user_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_schedule_user');
            $table->enum('type', ['available', 'eating'])->default('available');
            $table->time('schedule_start');
            $table->time('schedule_end');
            $table->timestamps();

            $table->foreign('id_schedule_user', 'fk_schedule_user_schedule_user_detail')->references('id')->on('schedule_user')->onDelete('cascade');
        });

        
        Schema::create('schedule_user_booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_schedule_user')->nullable();
            $table->date('book_date');
            $table->enum('type', ['meeting', 'other'])->default('meeting');
            $table->time('book_start');
            $table->time('book_end');
            $table->timestamps();

            $table->foreign('id_schedule_user', 'fk_schedule_booking_schedule_user')->references('id')->on('schedule_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_user');
        Schema::dropIfExists('schedule_user_booking');
    }
};
