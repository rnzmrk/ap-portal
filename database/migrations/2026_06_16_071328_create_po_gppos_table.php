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
        Schema::create('po_gppos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('invoice_no');
            $table->string('po_no');
            $table->string('dr_no');
            $table->string('grpo');
            $table->string('amount');

            $table->json('files')->nullable();

            $table->string('check_no')->nullable();
            $table->text('amount_details')->nullable();
            $table->string('release_location')->nullable();

            $table->text('return_reason')->nullable();
            $table->string('status')->default('submitted');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('po_gppos');
    }
};
