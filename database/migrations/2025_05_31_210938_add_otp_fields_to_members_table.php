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
        Schema::table('members', function (Blueprint $table) {
            // Only add columns that don't exist
            if (!\Schema::hasColumn('members', 'otp_code')) {
                $table->string('otp_code', 6)->nullable();
            }
            if (!\Schema::hasColumn('members', 'otp_expires_at')) {
                $table->dateTime('otp_expires_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            //
        });
    }
};
