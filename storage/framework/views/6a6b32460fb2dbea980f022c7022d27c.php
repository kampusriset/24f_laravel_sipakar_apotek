<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Rekam Medis Pasien - Sistem Apotek Pintar</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="container mx-auto p-6 max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pendaftaran Rekam Medis Pasien</h1>
                <p class="text-xs text-gray-500">Sistem Pakar Deteksi Alergi &amp; Efek Samping Obat</p>
            </div>
            <a href="/pos" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded transition">
                &larr; Ke Kasir POS
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form id="form-pasien" onsubmit="simpanPasien(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600">Nama Pasien</label>
                    <input type="text" id="reg_nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 bg-gray-50 border focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600">Usia (tahun)</label>
                    <input type="number" id="reg_usia" min="0" max="120" placeholder="cth: 45" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 bg-gray-50 border focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Anak: ≤12 th &middot; Dewasa: 13–65 th &middot; Lansia: &gt;65 th</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Riwayat Alergi Golongan Obat</label>
                    <div class="space-y-1 text-sm">
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_alergi" value="Penisilin" class="mr-2"> Penisilin</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_alergi" value="NSAID" class="mr-2"> NSAID</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_alergi" value="Makrolida" class="mr-2"> Makrolida</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_alergi" value="Sulfa" class="mr-2"> Sulfa</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Riwayat Penyakit / Kondisi Patologis</label>
                    <div class="space-y-1 text-sm">
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Tukak Lambung" class="mr-2"> Tukak Lambung / Maag Kronis</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Penyakit Ginjal" class="mr-2"> Penyakit / Gangguan Ginjal</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Penyakit Hati" class="mr-2"> Penyakit Hati</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Hipertensi" class="mr-2"> Hipertensi</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Asma" class="mr-2"> Asma</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Diabetes Melitus" class="mr-2"> Diabetes Melitus</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Gout" class="mr-2"> Gout / Asam Urat</label>
                        <label class="inline-flex items-center block"><input type="checkbox" name="reg_kondisi" value="Kejang" class="mr-2"> Riwayat Kejang / Epilepsi</label>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kondisi Kesehatan Khusus</label>
                    <div class="space-y-1 text-sm">
                        <label class="inline-flex items-center block"><input type="checkbox" id="reg_hamil" class="mr-2"> Sedang Hamil</label>
                        <label class="inline-flex items-center block"><input type="checkbox" id="reg_menyusui" class="mr-2"> Sedang Menyusui</label>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-md hover:bg-blue-700 transition font-medium">
                    Simpan Rekam Medis Pasien
                </button>
            </form>
        </div>
    </div>

    <script>
        function simpanPasien(e) {
            e.preventDefault();
            const nama = document.getElementById('reg_nama').value;
            const usia = document.getElementById('reg_usia').value;
            const allergies = Array.from(document.querySelectorAll('input[name="reg_alergi"]:checked')).map(el => el.value);
            const medical_conditions = Array.from(document.querySelectorAll('input[name="reg_kondisi"]:checked')).map(el => el.value);
            const isPregnant = document.getElementById('reg_hamil').checked;
            const isBreastfeeding = document.getElementById('reg_menyusui').checked;

            fetch('/proses-patients', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    name: nama,
                    age: usia ? parseInt(usia) : null,
                    allergies,
                    medical_conditions,
                    is_pregnant: isPregnant,
                    is_breastfeeding: isBreastfeeding
                })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message || 'Pasien berhasil terdaftar!');
                document.getElementById('form-pasien').reset();
            })
            .catch(err => alert('Gagal mendaftarkan pasien: ' + err.message));
        }
    </script>
</body>
</html><?php /**PATH C:\laragon\www\apotek33333\resources\views/patients/create.blade.php ENDPATH**/ ?>