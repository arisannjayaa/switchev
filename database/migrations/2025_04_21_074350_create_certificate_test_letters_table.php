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
        Schema::create('certificate_test_letters', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->foreignUuid('test_letter_id')->constrained('test_letters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type_test_attachment')->nullable();
            $table->string('registration_attachment')->nullable();
            $table->string('sk_attachment')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_test_letters');
    }
};
