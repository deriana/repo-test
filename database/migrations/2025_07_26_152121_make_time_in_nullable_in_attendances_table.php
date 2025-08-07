<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('time_in')->nullable()->change();
            $table->date('date')->nullable()->change(); // ✅ perbaiki posisi
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('time_in')->nullable(false)->change();
            $table->date('date')->nullable(false)->change(); // ✅ perbaiki posisi
        });
    }
};
