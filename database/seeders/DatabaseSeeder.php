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
        // =====================================================
        $obat = [
            [
                'nama_obat' => 'Amoxicillin 500mg', 
                'category' => 'Antibiotik', 
                'chemical_group' => 'Penisilin', 
                'side_effects' => json_encode(['Mual', 'Diare', 'Ruam kulit']), 
                'stok' => 50, 
                'harga_jual' => 5000,
                'harga_beli' => 4000
            ],
            [
                'nama_obat' => 'Eritromisin 250mg', 
                'category' => 'Antibiotik', 
                'chemical_group' => 'Makrolida', 
                'side_effects' => json_encode(['Sakit perut', 'Kram lambung']), 
                'stok' => 30, 
                'harga_jual' => 7500,
                'harga_beli' => 6000
            ],
            [
                'nama_obat' => 'Tetrasiklin HCl 500mg', 
                'category' => 'Antibiotik', 
                'chemical_group' => 'Tetrasiklin', 
                'side_effects' => json_encode(['Fotosensitivitas', 'Perubahan warna gigi']), 
                'stok' => 25, 
                'harga_jual' => 6000,
                'harga_beli' => 5000
            ],
            [
                'nama_obat' => 'Cotrimoxazole 480mg', 
                'category' => 'Antibiotik', 
                'chemical_group' => 'Sulfonamida', 
                'side_effects' => json_encode(['Ruam kulit', 'Mual']), 
                'stok' => 35, 
                'harga_jual' => 4500,
                'harga_beli' => 3500
            ],
            [
                'nama_obat' => 'Ciprofloxacin 500mg', 
                'category' => 'Antibiotik', 
                'chemical_group' => 'Fluorokuinolon', 
                'side_effects' => json_encode(['Nyeri sendi', 'Mual']), 
                'stok' => 40, 
                'harga_jual' => 6500,
                'harga_beli' => 5500
            ],
            [
                'nama_obat' => 'Kloramfenikol 250mg', 
                'category' => 'Antibiotik', 
                'chemical_group' => 'Kloramfenikol', 
                'side_effects' => json_encode(['Gangguan darah (jarang)', 'Mual']), 
                'stok' => 20, 
                'harga_jual' => 5500,
                'harga_beli' => 4500
            ],
            [
                'nama_obat' => 'Gentamisin Injeksi', 
                'category' => 'Antibiotik', 
                'chemical_group' => 'Aminoglikosida', 
                'side_effects' => json_encode(['Gangguan pendengaran (jarang)', 'Nefrotoksik']), 
                'stok' => 15, 
                'harga_jual' => 12000,
                'harga_beli' => 10000
            ],
            [
                'nama_obat' => 'Asam Mefenamat 500mg', 
                'category' => 'Analgetik', 
                'chemical_group' => 'NSAID', 
                'side_effects' => json_encode(['Nyeri lambung', 'Mual']), 
                'stok' => 40, 
                'harga_jual' => 3000,
                'harga_beli' => 2000
            ],
            [
                'nama_obat' => 'Ibuprofen 400mg', 
                'category' => 'Analgetik', 
                'chemical_group' => 'NSAID', 
                'side_effects' => json_encode(['Nyeri lambung', 'Perdarahan GI']), 
                'stok' => 45, 
                'harga_jual' => 3500,
                'harga_beli' => 2500
            ],
            [
                'nama_obat' => 'Paracetamol 500mg', 
                'category' => 'Analgetik', 
                'chemical_group' => 'Anilin', 
                'side_effects' => json_encode(['Gangguan hati jika berlebih']), 
                'stok' => 100, 
                'harga_jual' => 2000,
                'harga_beli' => 1500
            ],
            [
                'nama_obat' => 'Tramadol 50mg', 
                'category' => 'Analgetik', 
                'chemical_group' => 'Opioid Sintetik', 
                'side_effects' => json_encode(['Mengantuk', 'Mual', 'Menurunkan ambang kejang']), 
                'stok' => 20, 
                'harga_jual' => 4000,
                'harga_beli' => 3000
            ],
            [
                'nama_obat' => 'Metformin 500mg', 
                'category' => 'Antidiabetes', 
                'chemical_group' => 'Biguanid', 
                'side_effects' => json_encode(['Gangguan pencernaan', 'Asidosis laktat (jarang)']), 
                'stok' => 60, 
                'harga_jual' => 2500,
                'harga_beli' => 1800
            ],
            [
                'nama_obat' => 'Deksametason 0.5mg', 
                'category' => 'Kortikosteroid', 
                'chemical_group' => 'Kortikosteroid', 
                'side_effects' => json_encode(['Hiperglikemia', 'Retensi cairan']), 
                'stok' => 30, 
                'harga_jual' => 3000,
                'harga_beli' => 2200
            ],
            [
                'nama_obat' => 'Pseudoefedrin 60mg', 
                'category' => 'Dekongestan', 
                'chemical_group' => 'Dekongestan', 
                'side_effects' => json_encode(['Jantung berdebar', 'Insomnia']), 
                'stok' => 35, 
                'harga_jual' => 4000,
                'harga_beli' => 3000
            ],
            [
                'nama_obat' => 'Diazepam 5mg', 
                'category' => 'Sedatif', 
                'chemical_group' => 'Benzodiazepin', 
                'side_effects' => json_encode(['Mengantuk', 'Sedasi berlebihan']), 
                'stok' => 25, 
                'harga_jual' => 3500,
                'harga_beli' => 2500
            ],
            [
                'nama_obat' => 'Propranolol 10mg', 
                'category' => 'Antihipertensi', 
                'chemical_group' => 'Beta Blocker', 
                'side_effects' => json_encode(['Bronkospasme', 'Bradikardia']), 
                'stok' => 30, 
                'harga_jual' => 3000,
                'harga_beli' => 2200
            ],
            [
                'nama_obat' => 'Hidroklorotiazid 25mg', 
                'category' => 'Diuretik', 
                'chemical_group' => 'Diuretik Tiazid', 
                'side_effects' => json_encode(['Hiperurisemia', 'Gangguan elektrolit']), 
                'stok' => 40, 
                'harga_jual' => 2500,
                'harga_beli' => 1800
            ],
        ];

        foreach ($obat as $item) {
            Medicine::create($item);
        }

        // =====================================================
        // 2. DATA PASIEN CONTOH
        // =====================================================
        Patient::create([
            'name' => 'Budi Santoso',
            'age' => 45,
            'allergies' => ['Penisilin'],           
            'medical_conditions' => ['Maag Kronis'], 
            'is_pregnant' => false,
            'is_breastfeeding' => false,
        ]);

        Patient::create([
            'name' => 'Siti Aminah',
            'age' => 28,
            'allergies' => ['Sulfa', 'NSAID'],      
            'medical_conditions' => ['Hipertensi', 'Diabetes Melitus'], 
            'is_pregnant' => true,                    
            'is_breastfeeding' => false,
        ]);

        Patient::create([
            'name' => 'Suparjo (Lansia)',
            'age' => 70,                              
            'allergies' => [],
            'medical_conditions' => ['Penyakit Ginjal', 'Asma'], 
            'is_pregnant' => false,
            'is_breastfeeding' => false,
        ]);

        Patient::create([
            'name' => 'Rina (Menyusui)',
            'age' => 30,
            'allergies' => [],
            'medical_conditions' => ['Penyakit Hati', 'Gout'], 
            'is_pregnant' => false,
            'is_breastfeeding' => true,                
        ]);
    }
}