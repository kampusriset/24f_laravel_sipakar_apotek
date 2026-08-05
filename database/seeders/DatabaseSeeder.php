<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use App\Models\Patient;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================
        // 1. DATA OBAT
        // chemical_group dibuat konsisten dengan target_group
        // pada 16 rule di PharmacyAiService (Knowledge Base).
        // =====================================================
        $obat = [
            ['name' => 'Amoxicillin 500mg', 'category' => 'Antibiotik', 'chemical_group' => 'Penisilin', 'side_effects' => ['Mual', 'Diare', 'Ruam kulit'], 'stock' => 50, 'price' => 5000],
            ['name' => 'Eritromisin 250mg', 'category' => 'Antibiotik', 'chemical_group' => 'Makrolida', 'side_effects' => ['Sakit perut', 'Kram lambung'], 'stock' => 30, 'price' => 7500],
            ['name' => 'Tetrasiklin HCl 500mg', 'category' => 'Antibiotik', 'chemical_group' => 'Tetrasiklin', 'side_effects' => ['Fotosensitivitas', 'Perubahan warna gigi'], 'stock' => 25, 'price' => 6000],
            ['name' => 'Cotrimoxazole 480mg', 'category' => 'Antibiotik', 'chemical_group' => 'Sulfonamida', 'side_effects' => ['Ruam kulit', 'Mual'], 'stock' => 35, 'price' => 4500],
            ['name' => 'Ciprofloxacin 500mg', 'category' => 'Antibiotik', 'chemical_group' => 'Fluorokuinolon', 'side_effects' => ['Nyeri sendi', 'Mual'], 'stock' => 40, 'price' => 6500],
            ['name' => 'Kloramfenikol 250mg', 'category' => 'Antibiotik', 'chemical_group' => 'Kloramfenikol', 'side_effects' => ['Gangguan darah (jarang)', 'Mual'], 'stock' => 20, 'price' => 5500],
            ['name' => 'Gentamisin Injeksi', 'category' => 'Antibiotik', 'chemical_group' => 'Aminoglikosida', 'side_effects' => ['Gangguan pendengaran (jarang)', 'Nefrotoksik'], 'stock' => 15, 'price' => 12000],

            ['name' => 'Asam Mefenamat 500mg', 'category' => 'Analgetik', 'chemical_group' => 'NSAID', 'side_effects' => ['Nyeri lambung', 'Mual'], 'stock' => 40, 'price' => 3000],
            ['name' => 'Ibuprofen 400mg', 'category' => 'Analgetik', 'chemical_group' => 'NSAID', 'side_effects' => ['Nyeri lambung', 'Perdarahan GI'], 'stock' => 45, 'price' => 3500],
            ['name' => 'Paracetamol 500mg', 'category' => 'Analgetik', 'chemical_group' => 'Anilin', 'side_effects' => ['Gangguan hati jika berlebih'], 'stock' => 100, 'price' => 2000],
            ['name' => 'Tramadol 50mg', 'category' => 'Analgetik', 'chemical_group' => 'Opioid Sintetik', 'side_effects' => ['Mengantuk', 'Mual', 'Menurunkan ambang kejang'], 'stock' => 20, 'price' => 4000],

            ['name' => 'Metformin 500mg', 'category' => 'Antidiabetes', 'chemical_group' => 'Biguanid', 'side_effects' => ['Gangguan pencernaan', 'Asidosis laktat (jarang)'], 'stock' => 60, 'price' => 2500],
            ['name' => 'Deksametason 0.5mg', 'category' => 'Kortikosteroid', 'chemical_group' => 'Kortikosteroid', 'side_effects' => ['Hiperglikemia', 'Retensi cairan'], 'stock' => 30, 'price' => 3000],
            ['name' => 'Pseudoefedrin 60mg', 'category' => 'Dekongestan', 'chemical_group' => 'Dekongestan', 'side_effects' => ['Jantung berdebar', 'Insomnia'], 'stock' => 35, 'price' => 4000],
            ['name' => 'Diazepam 5mg', 'category' => 'Sedatif', 'chemical_group' => 'Benzodiazepin', 'side_effects' => ['Mengantuk', 'Sedasi berlebihan'], 'stock' => 25, 'price' => 3500],
            ['name' => 'Propranolol 10mg', 'category' => 'Antihipertensi', 'chemical_group' => 'Beta Blocker', 'side_effects' => ['Bronkospasme', 'Bradikardia'], 'stock' => 30, 'price' => 3000],
            ['name' => 'Hidroklorotiazid 25mg', 'category' => 'Diuretik', 'chemical_group' => 'Diuretik Tiazid', 'side_effects' => ['Hiperurisemia', 'Gangguan elektrolit'], 'stock' => 40, 'price' => 2500],
        ];

        foreach ($obat as $item) {
            Medicine::create($item);
        }

        // =====================================================
        // 2. DATA PASIEN CONTOH
        // Setiap pasien dibuat untuk mendemonstrasikan rule
        // yang berbeda pada Knowledge Base.
        // =====================================================
        Patient::create([
            'name' => 'Budi Santoso',
            'age' => 45,
            'allergies' => ['Penisilin'],           // memicu R1
            'medical_conditions' => ['Maag Kronis'], // alias -> Tukak Lambung, memicu R4
            'is_pregnant' => false,
            'is_breastfeeding' => false,
        ]);

        Patient::create([
            'name' => 'Siti Aminah',
            'age' => 28,
            'allergies' => ['Sulfa', 'NSAID'],       // memicu R6 & R14
            'medical_conditions' => ['Hipertensi', 'Diabetes Melitus'], // memicu R8 & R12
            'is_pregnant' => true,                    // memicu R2 & R7
            'is_breastfeeding' => false,
        ]);

        Patient::create([
            'name' => 'Suparjo (Lansia)',
            'age' => 70,                              // memicu R9
            'allergies' => [],
            'medical_conditions' => ['Penyakit Ginjal', 'Asma'], // memicu R3, R15, R11
            'is_pregnant' => false,
            'is_breastfeeding' => false,
        ]);

        Patient::create([
            'name' => 'Rina (Menyusui)',
            'age' => 30,
            'allergies' => [],
            'medical_conditions' => ['Penyakit Hati', 'Gout'], // memicu R5, R13
            'is_pregnant' => false,
            'is_breastfeeding' => true,                // memicu R10
        ]);
    }
}
