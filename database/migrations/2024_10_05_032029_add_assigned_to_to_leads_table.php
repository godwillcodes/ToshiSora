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
        // Drop the foreign key constraint first
        $table->dropForeign(['assigned_to']);
        
        // Then drop the column
        $table->dropColumn('assigned_to');
    });
}
};
