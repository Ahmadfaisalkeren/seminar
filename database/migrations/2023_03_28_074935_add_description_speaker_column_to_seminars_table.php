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
            $table->string('speaker')->after('place')->nullable();
            $table->text('description')->nullable()->after('quota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            if (Schema::hasColumn('seminars', 'speaker', 'description')) {
                $table->dropColumn('speaker', 'description');
            }
        });
    }
};
