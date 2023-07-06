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
        Schema::table('seminars', function (Blueprint $table) {
            $table->string('place');
            $table->date('seminar_date')->nullable();
            $table->bigInteger('price');
            $table->integer('quota');
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            if (Schema::hasColumn('seminars', 'place', 'seminar_date', 'price', 'quota', 'image')) {
                $table->dropColumn('place', 'seminar_date', 'price', 'quota', 'image');
            }
        });
    }
};
