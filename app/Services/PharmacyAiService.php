<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\Patient;

/**
 * =====================================================================
 * SISTEM PAKAR: Deteksi Alergi dan Efek Samping Obat pada Pasien
 * =====================================================================
 * Metode   : Rule-Based System dengan Certainty Factor (CF)
 * Inferensi: Forward Chaining
 *
 * Alur kerja (sesuai dokumen Fitur AI Sistem Pakar Obat):
 *   1. Kumpulkan fakta klinis/data aktual pasien (buildFacts).
 *   2. Mesin inferensi mencocokkan fakta secara maju (forward chaining)
 *      dengan seluruh rule IF-THEN di basis pengetahuan (fireRules).
 *   3. Hitung tingkat keyakinan diagnosis memakai kombinasi
 *      Certainty Factor (combineCf).
 *   4. Susun laporan rekomendasi klinis final (screenPrescription).
 * =====================================================================
 */
class PharmacyAiService
{
    /**
     * Basis Pengetahuan (Knowledge Base) - 16 Rule (R1-R16).
     * Setiap rule:
     *  - source       : asal fakta pemicu (alergi | kondisi_penyakit | demografi | kondisi_khusus)
     *  - if           : syarat pada fakta pasien
     *  - target_group : golongan kimia obat yang dikenai rule ini (dicocokkan ke Medicine::chemical_group)
     *  - consequence  : tindakan/kesimpulan (THEN)
     *  - cf           : Certainty Factor (derajat keyakinan pakar)
     *  - category     : kategori risiko
     */
    protected function knowledgeBase(): array
    {
        return [
            [
                'code' => 'R1', 'source' => 'alergi',
                'if' => fn(array $f) => in_array('Penisilin', $f['allergies']),
                'target_group' => 'Penisilin',
                'consequence' => 'Hindari Amoxicillin',
                'cf' => 0.95, 'category' => 'Alergi Tinggi',
            ],
            [
                'code' => 'R2', 'source' => 'kondisi_khusus',
                'if' => fn(array $f) => $f['is_pregnant'],
                'target_group' => 'Tetrasiklin',
                'consequence' => 'Hindari Tetrasiklin',
                'cf' => 0.90, 'category' => 'Teratogenik',
            ],
            [
                'code' => 'R3', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Penyakit Ginjal', $f['conditions']),
                'target_group' => 'Biguanid',
                'consequence' => 'Hindari Metformin dosis tinggi',
                'cf' => 0.88, 'category' => 'Toksisitas Obat',
            ],
            [
                'code' => 'R4', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Tukak Lambung', $f['conditions']),
                'target_group' => 'NSAID',
                'consequence' => 'Hindari Ibuprofen',
                'cf' => 0.85, 'category' => 'Perdarahan GI',
            ],
            [
                'code' => 'R5', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Penyakit Hati', $f['conditions']),
                'target_group' => 'Anilin',
                'consequence' => 'Hindari Parasetamol dosis tinggi',
                'cf' => 0.87, 'category' => 'Hepatotoksik',
            ],
            [
                'code' => 'R6', 'source' => 'alergi',
                'if' => fn(array $f) => in_array('Sulfa', $f['allergies']),
                'target_group' => 'Sulfonamida',
                'consequence' => 'Hindari Cotrimoxazole',
                'cf' => 0.92, 'category' => 'Alergi Tinggi',
            ],
            [
                'code' => 'R7', 'source' => 'kondisi_khusus',
                'if' => fn(array $f) => $f['is_pregnant'],
                'target_group' => 'Fluorokuinolon',
                'consequence' => 'Hindari Ciprofloxacin',
                'cf' => 0.89, 'category' => 'Risk Severity Tinggi',
            ],
            [
                'code' => 'R8', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Hipertensi', $f['conditions']),
                'target_group' => 'Dekongestan',
                'consequence' => 'Hindari Pseudoefedrin',
                'cf' => 0.82, 'category' => 'Krisis Hipertensi',
            ],
            [
                'code' => 'R9', 'source' => 'demografi',
                'if' => fn(array $f) => $f['age_category'] === 'lansia',
                'target_group' => 'Benzodiazepin',
                'consequence' => 'Hindari Diazepam',
                'cf' => 0.80, 'category' => 'Sedasi Berlebihan / Jatuh',
            ],
            [
                'code' => 'R10', 'source' => 'kondisi_khusus',
                'if' => fn(array $f) => $f['is_breastfeeding'],
                'target_group' => 'Kloramfenikol',
                'consequence' => 'Hindari Kloramfenikol',
                'cf' => 0.86, 'category' => 'Toksisitas pada Bayi',
            ],
            [
                'code' => 'R11', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Asma', $f['conditions']),
                'target_group' => 'Beta Blocker',
                'consequence' => 'Hindari Propranolol',
                'cf' => 0.88, 'category' => 'Bronkospasme',
            ],
            [
                'code' => 'R12', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Diabetes Melitus', $f['conditions']),
                'target_group' => 'Kortikosteroid',
                'consequence' => 'Hindari Deksametason dosis tinggi',
                'cf' => 0.84, 'category' => 'Hiperglikemia',
            ],
            [
                'code' => 'R13', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Gout', $f['conditions']) || in_array('Asam Urat', $f['conditions']),
                'target_group' => 'Diuretik Tiazid',
                'consequence' => 'Hindari Tiazid',
                'cf' => 0.78, 'category' => 'Hiperurisemia',
            ],
            [
                'code' => 'R14', 'source' => 'alergi',
                'if' => fn(array $f) => in_array('NSAID', $f['allergies']),
                'target_group' => 'NSAID',
                'consequence' => 'Hindari Asam Mefenamat',
                'cf' => 0.93, 'category' => 'Alergi Tinggi',
            ],
            [
                'code' => 'R15', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Penyakit Ginjal', $f['conditions']),
                'target_group' => 'Aminoglikosida',
                'consequence' => 'Hindari Gentamisin',
                'cf' => 0.90, 'category' => 'Nefrotoksik',
            ],
            [
                'code' => 'R16', 'source' => 'kondisi_penyakit',
                'if' => fn(array $f) => in_array('Kejang', $f['conditions']) || in_array('Epilepsi', $f['conditions']),
                'target_group' => 'Opioid Sintetik',
                'consequence' => 'Hindari Tramadol',
                'cf' => 0.83, 'category' => 'Penurunan Ambang Kejang',
            ],
        ];
    }

    /**
     * ENTRY POINT - dipanggil dari SalesController::checkItemSafety()
     *
     * Output mengikuti poin "8. Output Rekomendasi" pada dokumen:
     *  1. risiko_alergi       -> Risiko Alergi Obat
     *  2. risiko_efek_samping -> Risiko Efek Samping Obat (per rule yang aktif)
     *  3. nilai_keyakinan     -> Nilai Keyakinan Diagnosis (CF dalam persen)
     *  4. rekomendasi         -> Rekomendasi Penggunaan/Penggantian Obat
     */
    public function screenPrescription($patientId, $medicineId): array
    {
        $patient = Patient::findOrFail($patientId);
        $medicine = Medicine::findOrFail($medicineId);

        $facts = $this->buildFacts($patient);
        $firedRules = $this->fireRules($facts, $medicine);

        // Tidak ada rule yang aktif -> obat dinyatakan aman
        if (empty($firedRules)) {
            return [
                'status' => 'safe',
                'message' => "Obat {$medicine->name} aman untuk diberikan berdasarkan rekam medis pasien.",
                'risiko_alergi' => false,
                'risiko_efek_samping' => [],
                'nilai_keyakinan' => 0,
                'rekomendasi' => 'Obat dapat digunakan sesuai dosis anjuran.',
                'alternatives' => [],
            ];
        }

        $cf = $this->combineCf($firedRules);
        $risikoAlergi = collect($firedRules)->contains(fn($r) => $r['source'] === 'alergi');

        $risikoEfekSamping = collect($firedRules)->map(fn($r) => [
            'rule' => $r['code'],
            'kategori_risiko' => $r['category'],
            'keterangan' => $r['consequence'],
            'cf' => $r['cf'],
        ])->values()->all();

        $kodeRule = collect($firedRules)->pluck('code')->implode(', ');
        $kategoriUtama = $firedRules[0]['category'];

        return [
            'status' => 'danger',
            'message' => "PERINGATAN ({$kodeRule}): {$medicine->name} berisiko \"{$kategoriUtama}\" untuk pasien ini!",
            'risiko_alergi' => $risikoAlergi,
            'risiko_efek_samping' => $risikoEfekSamping,
            'nilai_keyakinan' => round($cf * 100, 2), // persentase keyakinan diagnosis
            'rekomendasi' => "Hentikan/hindari {$medicine->name}. Pertimbangkan obat alternatif di bawah ini.",
            'alternatives' => $this->getAlternatives($medicine, $facts),
        ];
    }

    /**
     * Tahap 1 Alur Kerja: pengumpulan fakta klinis aktual pasien.
     * Alias ditambahkan agar kompatibel dengan data/checkbox lama
     * ("Maag Kronis" -> "Tukak Lambung", "Gangguan Ginjal" -> "Penyakit Ginjal").
     */
    protected function buildFacts(Patient $patient): array
    {
        $allergies = is_string($patient->allergies) ? json_decode($patient->allergies, true) : $patient->allergies;
        $conditions = is_string($patient->medical_conditions) ? json_decode($patient->medical_conditions, true) : $patient->medical_conditions;

        $allergies = array_values(array_filter((array) $allergies));
        $conditions = array_values(array_filter((array) $conditions));

        $aliasKondisi = [
            'Maag Kronis' => 'Tukak Lambung',
            'Gangguan Ginjal' => 'Penyakit Ginjal',
        ];
        foreach ($aliasKondisi as $lama => $baru) {
            if (in_array($lama, $conditions) && !in_array($baru, $conditions)) {
                $conditions[] = $baru;
            }
        }

        return [
            'allergies' => $allergies,
            'conditions' => $conditions,
            'age_category' => $patient->age_category,
            'is_pregnant' => (bool) $patient->is_pregnant,
            'is_breastfeeding' => (bool) $patient->is_breastfeeding,
        ];
    }

    /**
     * Tahap 2 Alur Kerja: Forward Chaining.
     * Mencocokkan fakta pasien dengan seluruh rule IF-THEN yang relevan
     * dengan golongan kimia obat yang akan diberikan.
     */
    protected function fireRules(array $facts, Medicine $medicine): array
    {
        $fired = [];
        foreach ($this->knowledgeBase() as $rule) {
            $golonganCocok = strcasecmp($medicine->chemical_group, $rule['target_group']) === 0;
            if ($golonganCocok && call_user_func($rule['if'], $facts)) {
                $fired[] = $rule;
            }
        }
        return $fired;
    }

    /**
     * Tahap 3 Alur Kerja: kombinasi Certainty Factor.
     * Jika lebih dari satu rule aktif untuk obat yang sama, CF digabung
     * dengan rumus kombinasi evidence paralel:
     *   CF_gabungan = CF1 + CF2 * (1 - CF1), diulang untuk rule berikutnya.
     */
    protected function combineCf(array $firedRules): float
    {
        $cfGabungan = 0.0;
        foreach ($firedRules as $rule) {
            $cfGabungan = $cfGabungan + ($rule['cf'] * (1 - $cfGabungan));
        }
        return round($cfGabungan, 4);
    }

    /**
     * Mencari obat alternatif: kategori terapi sama, golongan kimia
     * berbeda, stok tersedia, dan lolos seluruh rule (benar-benar aman
     * untuk fakta pasien yang sama, bukan hanya untuk 1-2 kasus khusus).
     */
    private function getAlternatives(Medicine $unsafeMedicine, array $facts): array
    {
        $kandidat = Medicine::where('category', $unsafeMedicine->category)
            ->where('chemical_group', '!=', $unsafeMedicine->chemical_group)
            ->where('stock', '>', 0)
            ->get();

        $hasil = [];
        foreach ($kandidat as $alt) {
            if (!empty($this->fireRules($facts, $alt))) {
                continue; // obat ini juga berisiko bagi pasien -> lewati
            }

            $hasil[] = [
                'id' => $alt->id,
                'name' => $alt->name,
                'chemical_group' => $alt->chemical_group,
                'side_effects' => is_string($alt->side_effects) ? json_decode($alt->side_effects, true) : $alt->side_effects,
                'price' => $alt->price,
            ];
        }

        return $hasil;
    }
}
