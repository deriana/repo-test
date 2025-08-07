<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('rekap_absens', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->integer('hadir')->default(0);
        $table->integer('telat')->default(0);
        $table->integer('izin')->default(0);
        $table->integer('alpha')->default(0);
        $table->date('start_date')->nullable(); // periode awal
        $table->date('end_date')->nullable();   // periode akhir
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_absens');
    }
};
