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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('loan_date');
            $table->date('due_date');
            $table->integer('jumlah');
            $table->string('noted')->nullable();
            $table->enum('status', [
                'pending',
                'borrowed',
                'returned',
                'rejected',
                'overdue',
                'lost-compensated'
            ])->default('pending');
            $table->enum('status_fine', ['unpaid', 'paid'])->nullable();
            $table->date('return_date')->nullable();
            $table->bigInteger('fine')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
