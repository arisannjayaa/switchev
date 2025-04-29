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
            $table->string('workshop_type')->nullable();
            $table->string('sop_component_installation')->nullable();
            $table->string('technical_drawing')->nullable();
            $table->string('conversion_workshop_certificate')->nullable();
            $table->string('electrical_diagram')->nullable();
            $table->string('photocopy_stnk')->nullable();
            $table->string('physical_inspection')->nullable();
            $table->string('test_report')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->string('physical_test_bpljskb')->nullable();
            $table->string('physical_test_cover_letter')->nullable();
            $table->string('responsible_person')->nullable();
            $table->string('telephone')->nullable();
            $table->string('workshop')->nullable();
            $table->string('address')->nullable();
            // data motor
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('type_vehicle')->nullable();
            $table->string('trademark')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('variant')->nullable();
            $table->string('allotment')->nullable();
            $table->string('transmission')->nullable();
            $table->string('drive_system')->nullable();
            $table->string('chassis')->nullable();
            $table->string('chassis_place_number')->nullable();
            $table->string('chassis_method_number')->nullable();
            $table->string('pre_conversion_engine')->nullable();
            $table->string('pre_conversion_engine_place_number')->nullable();
            $table->string('pre_conversion_engine_method_number')->nullable();
            $table->string('post_conversion_engine')->nullable();
            $table->string('post_conversion_engine_place_number')->nullable();
            $table->string('post_conversion_engine_method_number')->nullable();
            $table->json('drive_motor')->nullable();
            $table->json('fuel_system')->nullable();
            $table->json('vehicle_dimension')->nullable();
            $table->json('axis_configuration')->nullable();
            $table->json('tire_size')->nullable();
            $table->json('vehicle_weight')->nullable();
            $table->json('power_forwarder')->nullable();
            $table->json('braking_system')->nullable();
            $table->json('suspension_system')->nullable();
            $table->json('other')->nullable();
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
