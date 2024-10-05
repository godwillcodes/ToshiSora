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
        Schema::table('leads', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('leads', function (Blueprint $table) {
        // Check if the column exists before dropping it
        if (Schema::hasColumn('leads', 'assigned_to')) {
            $table->dropColumn('assigned_to');
        }
    });
}
};
