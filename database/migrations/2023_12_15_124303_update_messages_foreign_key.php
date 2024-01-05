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
    Schema::table('messages', function (Blueprint $table) {
        // Drop the existing foreign key constraint
        $table->dropForeign(['booking_id']);  // Replace with the actual constraint name if different

        // Re-add the foreign key constraint with ON DELETE SET NULL
        $table->foreign('booking_id')
              ->references('id')->on('bookings')
              ->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        // Drop the updated foreign key constraint
        $table->dropForeign(['booking_id']);  // Replace with the actual constraint name if different

        // Re-add the original foreign key constraint without ON DELETE SET NULL
        $table->foreign('booking_id')
              ->references('id')->on('bookings');
              // If you previously had a different onDelete behavior, set it here
    });
}
};
