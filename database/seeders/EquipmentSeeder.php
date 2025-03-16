<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conversionId = '72h0k3vls8kc88ko';
        $userId = 'h221cvqljwo4ks40';

        $types = ['Hand Tool', 'Power Tool', 'Diagnostic Tool', 'Lifting Equipment', 'Safety Equipment'];
        $brands = ['Bosch', 'Makita', 'Snap-On', 'DeWalt', 'Hitachi', 'Honda', '3M'];
        $names = ['Wrench Set', 'Impact Drill', 'OBD2 Scanner', 'Hydraulic Lift', 'Safety Goggles'];

        $equipments = [];
        for ($i = 1; $i <= 20; $i++) {
            $equipments[] = [
                'id' => Helper::generate_uuid(),
                'conversion_id' => $conversionId,
                'user_id' => $userId,
                'type' => $types[array_rand($types)],
                'name' => $names[array_rand($names)],
                'brand' => $brands[array_rand($brands)],
                'specification' => 'Units: ' . rand(1, 10) . ', Expiry: ' . now()->addYears(rand(1, 5))->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('equipments')->insert($equipments);
    }
}
