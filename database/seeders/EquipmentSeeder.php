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
        DB::table('equipments')->truncate();
        $conversionId = '49r3wy6uxi80sckk';
        $userId = '6xrdbflbc000wo48';

        $types = ['Peralatan Khusus Instalasi', 'Peralatan tangan dan peralatan bertenaga', 'Peralatan uji perlindungan sentuh Listrik', 'Fasilitas keamanan dan keselamatan kerja'];
        $brands = ['Bosch', 'Makita', 'Snap-On', 'DeWalt', 'Hitachi', 'Honda', '3M'];
        $names = ['Wrench Set', 'Impact Drill', 'OBD2 Scanner', 'Hydraulic Lift', 'Safety Goggles'];

        $equipments = [];
        for ($i = 1; $i <= 100; $i++) {
            $equipments[] = [
                'id' => Helper::generate_uuid(),
                'conversion_id' => $conversionId,
                'user_id' => $userId,
                'type' => $types[array_rand($types)],
                'name' => $names[array_rand($names)],
                'brand' => $brands[array_rand($brands)],
                'specification' => 'Units: ' . rand(1, 10),
                'status' => 'Sesuai',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('equipments')->insert($equipments);
    }
}
