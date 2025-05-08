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
        Schema::table('test_letters', function (Blueprint $table) {
            $table->string('quality_control')->nullable()->after('conversion_type_test_application_letter');
            $table->string('permohonan_srut')->nullable()->after('conversion_type_test_application_letter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_letters', function (Blueprint $table) {
            //
        });
    }
};
