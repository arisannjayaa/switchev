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
            $table->string('brand')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('type')->nullable();
            $table->string('purpose_vehicle')->nullable();
            $table->string('chassis')->nullable();
            $table->string('electric_motor_number')->nullable();
            $table->string('year_build')->nullable();
            $table->string('axis_1_2')->nullable();
            $table->string('axis_2_3')->nullable();
            $table->string('axis_3_4')->nullable();
            $table->string('width_total')->nullable();
            $table->string('length_total')->nullable();
            $table->string('height_total')->nullable();
            $table->string('julur_front')->nullable();
            $table->string('julur_rear')->nullable();
            $table->string('power_max')->nullable();
            $table->string('battery_max')->nullable();
            $table->string('tire_axis_1')->nullable();
            $table->string('tire_axis_2')->nullable();
            $table->string('tire_axis_3')->nullable();
            $table->string('tire_axis_4')->nullable();
            $table->string('jbb')->nullable();
            $table->string('empty_weight')->nullable();
            $table->string('jbi')->nullable();
            $table->string('carry_capacity')->nullable();
            $table->string('road_class')->nullable();
            $table->date('date_bpljskb')->nullable();
            $table->string('place_test_bpljskb')->nullable();
            $table->date('date_sut')->nullable();
            $table->date('date_srut')->nullable();
            $table->date('date_sk')->nullable();
            $table->date('qr_code')->nullable();
            $table->string('type_test_attachment')->nullable();
            $table->string('registration_attachment')->nullable();
            $table->string('sk_attachment')->nullable();
            $table->boolean('is_form_completed')->nullable()->default(0);
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
