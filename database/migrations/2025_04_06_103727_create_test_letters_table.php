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
        Schema::create('test_letters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->string('sop_component_installation')->nullable();
            $table->string('technical_drawing')->nullable();
            $table->string('conversion_workshop_certificate')->nullable();
            $table->string('electrical_diagram')->nullable();
            $table->string('photocopy_stnk')->nullable();
            $table->string('physical_inspection')->nullable();
            $table->string('test_report')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->string('physical_testing_bpljskb')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_letters');
    }
};
