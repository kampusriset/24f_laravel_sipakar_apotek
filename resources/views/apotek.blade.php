<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Pharmacy System - AI Powered</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="container mx-auto p-6">
<<<<<<< HEAD
        <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Sistem Apotek Pintar Berbasis AI</h1>
=======
        <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">🤖 Sistem Apotek Pintar Berbasis AI</h1>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
        <p class="text-center text-sm text-gray-500 mb-6">Sistem Pakar Deteksi Alergi &amp; Efek Samping Obat — Rule-Based + Certainty Factor + Forward Chaining</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-lg shadow-md h-fit">
<<<<<<< HEAD
                <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Pendaftaran Rekam Medis Pasien</h2>
=======
                <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">📋 Pendaftaran Rekam Medis Pasien</h2>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
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

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kondisi Kesehatan Khusus</label>
                        <div class="space-y-1 text-sm">
                            <label class="inline-flex items-center block"><input type="checkbox" id="reg_hamil" class="mr-2"> Sedang Hamil</label>
                            <label class="inline-flex items-center block"><input type="checkbox" id="reg_menyusui" class="mr-2"> Sedang Menyusui</label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Daftarkan Pasien</button>
                </form>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
<<<<<<< HEAD
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Keranjang Kasir POS</h2>
=======
                    <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">🛒 Keranjang Kasir POS</h2>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600">Pilih Pasien Transaksi</label>
                        <select id="kasir_patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 bg-gray-50 border">
                            @forelse ($patients as $patient)
                                <option value="{{ $patient->id }}">
                                    {{ $patient->name }}
                                    (Alergi: {{ count($patient->allergies ?? []) ? implode(', ', $patient->allergies) : '-' }},
                                    Kondisi: {{ count($patient->medical_conditions ?? []) ? implode(', ', $patient->medical_conditions) : '-' }})
                                </option>
                            @empty
                                <option value="">Belum ada data pasien</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-6 grid grid-cols-3 gap-4 bg-blue-50 p-4 rounded-md border border-blue-100">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-600">Pilih Obat untuk Ditambahkan</label>
                            <select id="kasir_medicine_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 bg-white border">
                                <option value="">-- Pilih --</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }} ({{ $medicine->category }} - {{ $medicine->chemical_group }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Qty</label>
                            <input type="number" id="kasir_qty" value="1" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 bg-white border">
                        </div>
                        <button onclick="prosesTambahObat()" class="col-span-3 bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition font-medium">
                            + Validasi &amp; Tambah ke Keranjang
                        </button>
                    </div>

                    <div id="ai-alert-box" class="hidden mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                        <div class="flex items-start">
<<<<<<< HEAD
                            <div class="text-xl mr-2"></div>
=======
                            <div class="text-xl mr-2">⚠️</div>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                            <div class="w-full">
                                <h3 class="text-red-800 font-bold">AI Screening: Bahaya Terdeteksi!</h3>
                                <p id="ai-warning-message" class="text-red-700 text-sm mt-1"></p>

                                <div class="mt-3 flex flex-wrap gap-3 text-xs">
<<<<<<< HEAD
                                    <span id="ai-badge-alergi" class="hidden px-2 py-1 rounded bg-red-200 text-red-800 font-semibold">Risiko Alergi Obat</span>
=======
                                    <span id="ai-badge-alergi" class="hidden px-2 py-1 rounded bg-red-200 text-red-800 font-semibold">🔴 Risiko Alergi Obat</span>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                                    <span class="px-2 py-1 rounded bg-gray-200 text-gray-800 font-semibold">
                                        Nilai Keyakinan Diagnosis (CF): <span id="ai-cf-value">0</span>%
                                    </span>
                                </div>

                                <div class="mt-3">
<<<<<<< HEAD
                                    <p class="text-xs font-bold text-gray-700 mb-1">Rincian Efek Samping / Kontraindikasi Terdeteksi:</p>
=======
                                    <p class="text-xs font-bold text-gray-700 mb-1">📌 Rincian Efek Samping / Kontraindikasi Terdeteksi:</p>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                                    <table class="w-full text-xs border border-red-200 bg-white rounded overflow-hidden">
                                        <thead class="bg-red-100 text-red-800">
                                            <tr>
                                                <th class="px-2 py-1 text-left">Rule</th>
                                                <th class="px-2 py-1 text-left">Kategori Risiko</th>
                                                <th class="px-2 py-1 text-left">Keterangan</th>
                                                <th class="px-2 py-1 text-right">CF</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ai-efek-samping-table"></tbody>
                                    </table>
                                </div>

                                <p class="mt-3 text-xs bg-yellow-50 border border-yellow-200 text-yellow-800 p-2 rounded">
<<<<<<< HEAD
                                    <strong>Rekomendasi:</strong> <span id="ai-rekomendasi-text"></span>
=======
                                    💊 <strong>Rekomendasi:</strong> <span id="ai-rekomendasi-text"></span>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                                </p>

                                <div id="ai-alternatives-list" class="mt-4 space-y-2"></div>
                            </div>
                        </div>
                    </div>

                    <div id="ai-safe-box" class="hidden mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                        <div class="flex items-start">
<<<<<<< HEAD
                            <div class="text-xl mr-2"></div>
=======
                            <div class="text-xl mr-2">✅</div>
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                            <p id="ai-safe-message" class="text-green-800 text-sm"></p>
                        </div>
                    </div>

                    <h3 class="font-medium text-gray-700 mb-2">Daftar Belanja:</h3>
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-keranjang" class="bg-white divide-y divide-gray-200 text-sm">
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-400">Keranjang masih kosong</td>
                            </tr>
                        </tbody>
                    </table>

                    <button onclick="checkoutTransaksi()" class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-md hover:bg-indigo-700 transition font-bold text-lg">
                         Proses Bayar (Simpan &amp; Potong Stok)
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script>
        let keranjangItems = [];

        // 1. FUNGSI MENDAFTARKAN PASIEN BARU
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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                alert(data.message);
                const selectPasien = document.getElementById('kasir_patient_id');
                const option = document.createElement('option');
                option.value = data.data.id;
                option.text = data.data.name + ' (Baru didaftarkan)';
                selectPasien.add(option);
                selectPasien.value = data.data.id;
                document.getElementById('form-pasien').reset();
            });
        }

        // 2. FUNGSI VALIDASI AI SEBELUM MASUK KERANJANG
        function prosesTambahObat() {
            const patientId = document.getElementById('kasir_patient_id').value;
            const medicineId = document.getElementById('kasir_medicine_id').value;
            const qty = parseInt(document.getElementById('kasir_qty').value);

            if(!medicineId) return alert('Silahkan pilih obat dulu!');
            if(!patientId) return alert('Silahkan daftarkan / pilih pasien dulu!');

            const alertBox = document.getElementById('ai-alert-box');
            const safeBox = document.getElementById('ai-safe-box');
            const warningMsg = document.getElementById('ai-warning-message');
            const altList = document.getElementById('ai-alternatives-list');
            const efekTable = document.getElementById('ai-efek-samping-table');
            const badgeAlergi = document.getElementById('ai-badge-alergi');
            const cfValue = document.getElementById('ai-cf-value');
            const rekomendasiText = document.getElementById('ai-rekomendasi-text');

            alertBox.classList.add('hidden');
            safeBox.classList.add('hidden');
            altList.innerHTML = '';
            efekTable.innerHTML = '';

            fetch('/proses-sales/check-safety', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ patient_id: patientId, medicine_id: medicineId })
            })
            .then(async res => {
                if (!res.ok) {
                    const textError = await res.text();
                    const match = textError.match(/<title>(.*?)<\/title>/) || textError.match(/<h1>(.*?)<\/h1>/);
                    const pesanSingkat = match ? match[1] : 'Eror tidak diketahui';
                    throw new Error('[Laravel PHP Error] ' + pesanSingkat);
                }
                return res.json();
            })
            .then(data => {
                if (data.status === 'danger') {
                    alertBox.classList.remove('hidden');
                    warningMsg.innerText = data.message;
                    cfValue.innerText = data.nilai_keyakinan;
                    rekomendasiText.innerText = data.rekomendasi;
                    badgeAlergi.classList.toggle('hidden', !data.risiko_alergi);

                    (data.risiko_efek_samping || []).forEach(r => {
                        efekTable.innerHTML += '<tr class="border-t border-red-100">' +
                            '<td class="px-2 py-1 font-semibold">' + r.rule + '</td>' +
                            '<td class="px-2 py-1">' + r.kategori_risiko + '</td>' +
                            '<td class="px-2 py-1">' + r.keterangan + '</td>' +
                            '<td class="px-2 py-1 text-right">' + (r.cf * 100).toFixed(0) + '%</td>' +
                            '</tr>';
                    });

                    if(data.alternatives.length > 0){
<<<<<<< HEAD
                        altList.innerHTML = '<p class="text-xs font-bold text-gray-700">Rekomendasi Obat Pengganti yang Aman:</p>';
=======
                        altList.innerHTML = '<p class="text-xs font-bold text-gray-700">💡 Rekomendasi Obat Pengganti yang Aman:</p>';
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                        data.alternatives.forEach(alt => {
                            altList.innerHTML += '<div class="bg-white p-2 rounded border border-red-200 flex justify-between items-center text-xs">' +
                                '<div><strong>' + alt.name + '</strong> <span class="text-gray-400">| Efek samping: ' + alt.side_effects.join(', ') + '</span></div>' +
                                '<button onclick="pilihAlternatif(' + alt.id + ')" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Gunakan Ini</button>' +
                                '</div>';
                        });
                    } else {
<<<<<<< HEAD
                        altList.innerHTML = '<p class="text-xs text-gray-500">Tidak ada alternatif aman yang tersedia di gudang saat ini.</p>';
=======
                        altList.innerHTML = '<p class="text-xs text-gray-500">❌ Tidak ada alternatif aman yang tersedia di gudang saat ini.</p>';
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                    }
                } else {
                    safeBox.classList.remove('hidden');
                    document.getElementById('ai-safe-message').innerText = data.message;
                    tambahKeKeranjangLokal(medicineId, qty);
                }
            })
            .catch(error => {
                console.error('Error detail:', error);
                alert(error.message);
            });
        }

        function pilihAlternatif(id) {
            document.getElementById('kasir_medicine_id').value = id;
            document.getElementById('ai-alert-box').classList.add('hidden');
            alert('Obat diganti ke rekomendasi AI. Silahkan klik "+ Validasi & Tambah ke Keranjang" lagi.');
        }

        function tambahKeKeranjangLokal(id, qty) {
            const selectObat = document.getElementById('kasir_medicine_id');
            const namaObat = selectObat.options[selectObat.selectedIndex].text;

            keranjangItems.push({ medicine_id: id, name: namaObat, quantity: qty });
            renderTabelKeranjang();
        }

        function renderTabelKeranjang() {
            const tbody = document.getElementById('tabel-keranjang');
            if(keranjangItems.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="px-4 py-4 text-center text-gray-400">Keranjang masih kosong</td></tr>';
                return;
            }
            tbody.innerHTML = '';
            keranjangItems.forEach((item, index) => {
                tbody.innerHTML += '<tr>' +
                    '<td class="px-4 py-2">' + item.name + '</td>' +
                    '<td class="px-4 py-2 text-center">' + item.quantity + '</td>' +
                    '<td class="px-4 py-2 text-right"><button onclick="hapusItem(' + index + ')" class="text-red-500 hover:underline">Hapus</button></td>' +
                    '</tr>';
            });
        }

        function hapusItem(index) {
            keranjangItems.splice(index, 1);
            renderTabelKeranjang();
        }

        // 3. FUNGSI SIMPAN FINAL TRANSAKSI (CHECKOUT)
        function checkoutTransaksi() {
            if(keranjangItems.length === 0) return alert('Keranjang belanja kosong!');
            const patientId = document.getElementById('kasir_patient_id').value;

            fetch('/proses-sales/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ patient_id: patientId, items: keranjangItems })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
<<<<<<< HEAD
                    alert('' + data.message + '\nNomor Nota: ' + data.invoice + '\nTotal: Rp ' + data.total_bayar);
=======
                    alert('🎉 ' + data.message + '\nNomor Nota: ' + data.invoice + '\nTotal: Rp ' + data.total_bayar);
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                    keranjangItems = [];
                    renderTabelKeranjang();
                } else {
                    alert('Gagal: ' + data.message);
                }
            });
        }
    </script>
</body>
</html>
