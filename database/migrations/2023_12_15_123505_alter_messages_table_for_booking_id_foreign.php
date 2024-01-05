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
        // First, make the booking_id column nullable
        $table->unsignedBigInteger('booking_id')->nullable()->change();

        // Next, drop the existing foreign key constraint
        $table->dropForeign(['booking_id']);

        // Finally, re-add the foreign key constraint with the desired onDelete behavior
        $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        // Drop the modified foreign key constraint
        $table->dropForeign(['booking_id']);

        // Re-add the original foreign key constraint without onDelete behavior specified
        $table->foreign('booking_id')->references('id')->on('bookings');

        // Make the booking_id column not nullable again
        $table->unsignedBigInteger('booking_id')->nullable(false)->change();
    });
}

};
