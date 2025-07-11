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
        Schema::create('convertions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('type');
            $table->string('workshop');
            $table->string('address');
            $table->string('person_responsible');
            $table->string('whatapp_responsible');
            $table->string('application_letter');
            $table->string('technician_competency');
            $table->string('equipment');
            $table->string('sop');
            $table->string('wiring_diagram');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convertions');
    }
};
