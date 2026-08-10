<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir POS - Sistem Apotek Pintar</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="container mx-auto p-6 max-w-5xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Keranjang Kasir POS &amp; Screening AI</h1>
                <p class="text-xs text-gray-500">Validasi Otomatis Alergi, Kontraindikasi, &amp; Interaksi Obat</p>
            </div>
            <a href="{{ route('kasir.rekam_medis') }}" class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded transition font-medium">
                + Tambah Pasien Baru
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
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

            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 bg-blue-50 p-4 rounded-md border border-blue-100">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Pilih Obat untuk Ditambahkan</label>
                    <select id="kasir_medicine_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 bg-white border">
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($medicines as $medicine)
                            {{-- Menyimpan harga jual ke atribut data-price agar bisa dibaca otomatis oleh JS --}}
                            <option value="{{ $medicine->id_obat ?? $medicine->id }}" data-price="{{ $medicine->harga_jual ?? 0 }}">
                                {{ $medicine->nama_obat ?? $medicine->name }} ({{ $medicine->category }} - {{ $medicine->chemical_group }}) - Rp {{ number_format($medicine->harga_jual ?? 0, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Qty</label>
                    <input type="number" id="kasir_qty" value="1" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 bg-white border">
                </div>
                <button type="button" id="btn-tambah-obat" class="md:col-span-3 bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition font-medium">
                    + Validasi &amp; Tambah ke Keranjang
                </button>
            </div>

            <div id="ai-alert-box" class="hidden mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex items-start">
                    <div class="text-xl mr-2">⚠️</div>
                    <div class="w-full">
                        <h3 class="text-red-800 font-bold">AI Screening: Bahaya Terdeteksi!</h3>
                        <p id="ai-warning-message" class="text-red-700 text-sm mt-1"></p>

                        <div class="mt-3 flex flex-wrap gap-3 text-xs">
                            <span id="ai-badge-alergi" class="hidden px-2 py-1 rounded bg-red-200 text-red-800 font-semibold">Risiko Alergi Obat</span>
                            <span class="px-2 py-1 rounded bg-gray-200 text-gray-800 font-semibold">
                                Nilai Keyakinan (CF): <span id="ai-cf-value">0</span>%
                            </span>
                        </div>

                        <div class="mt-3">
                            <p class="text-xs font-bold text-gray-700 mb-1">Rincian Efek Samping / Kontraindikasi Terdeteksi:</p>
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
                            <strong>Rekomendasi:</strong> <span id="ai-rekomendasi-text"></span>
                        </p>

                        <div id="ai-alternatives-list" class="mt-4 space-y-2"></div>
                    </div>
                </div>
            </div>

            <!-- AI Screening Result: Safe Box -->
            <div id="ai-safe-box" class="hidden mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                <div class="flex items-start">
                    <div class="text-xl mr-2">✅</div>
                    <p id="ai-safe-message" class="text-green-800 text-sm"></p>
                </div>
            </div>

            <h3 class="font-medium text-gray-700 mb-2">Daftar Belanja:</h3>
            <table class="min-w-full divide-y divide-gray-200 border rounded-md overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Obat</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-keranjang" class="bg-white divide-y divide-gray-200 text-sm">
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-400">Keranjang masih kosong</td>
                    </tr>
                </tbody>
            </table>

            <button onclick="checkoutTransaksi()" class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-md hover:bg-indigo-700 transition font-bold text-lg">
                Proses Bayar (Simpan)
            </button>
        </div>
    </div>

    <div id="checkout-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Konfirmasi Pembayaran</h3>
            
            <div class="space-y-3 mb-4 text-sm">
                <div class="flex justify-between border-b pb-2">
                    <span class="text-gray-600">Total Belanja:</span>
                    <span id="modal-total-display" class="font-bold text-gray-800 text-lg">Rp 0</span>
                </div>
                
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Metode Pembayaran</label>
                    <select id="payment-method" class="w-full border rounded-md p-2 bg-gray-50">
                        <option value="Cash">Cash (Tunai)</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer">Transfer Bank</option>
                    </select>
                </div>

                <div id="cash-input-section">
                    <label class="block text-gray-600 font-medium mb-1">Uang Diterima (Cash)</label>
                    <input type="number" id="cash-given" class="w-full border rounded-md p-2 border-gray-300" placeholder="Masukkan jumlah uang..." oninput="hitungKembalian()">
                    <div class="flex justify-between mt-1 text-xs text-gray-500">
                        <span>Kembalian:</span>
                        <span id="change-display" class="font-bold text-green-600">Rp 0</span>
                    </div>
                </div>
            </div>

            <div id="modal-action-buttons" class="space-y-2">
                <button onclick="prosesSimpanCheckout()" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition font-medium">
                    Konfirmasi &amp; Simpan Transaksi
                </button>
                <button onclick="tutupModalCheckout()" class="w-full bg-gray-200 text-gray-700 py-2 rounded-md hover:bg-gray-300 transition">
                    Batal
                </button>
            </div>

            <div id="success-action-section" class="hidden space-y-2 text-center">
                <div class="bg-green-50 text-green-700 p-3 rounded-md text-sm mb-3">
                    ✅ Transaksi Berhasil Disimpan! <br>
                    <span id="success-invoice" class="font-bold"></span>
                </div>
                <button onclick="cetakStruk()" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition font-medium">
                    🖨️ Cetak Struk
                </button>
                <button onclick="downloadPdf()" class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition font-medium">
                    📄 Kirim / Download PDF Struk
                </button>
                <button onclick="resetTransaksiBaru()" class="w-full bg-gray-200 text-gray-700 py-2 rounded-md hover:bg-gray-300 transition">
                    Transaksi Baru
                </button>
            </div>
        </div>
    </div>

   <script>
        let keranjangItems = [];
        let currentTotalBayar = 0;
        let lastInvoiceData = null;

        document.addEventListener("DOMContentLoaded", function() {
            const btnTambah = document.getElementById('btn-tambah-obat');
            if (btnTambah) {
                btnTambah.addEventListener('click', function(e) {
                    e.preventDefault();
                    prosesTambahObat();
                });
            }
        });

        function prosesTambahObat() {
            const patientId = document.getElementById('kasir_patient_id').value;
            const medicineSelect = document.getElementById('kasir_medicine_id');
            const medicineId = medicineSelect.value;
            const qty = parseInt(document.getElementById('kasir_qty').value);

            if(!medicineId) return alert('Silahkan pilih obat dulu!');
            if(!patientId) return alert('Silahkan pilih pasien dulu!');

            const selectedOption = medicineSelect.options[medicineSelect.selectedIndex];
            const namaObat = selectedOption.text.split(' (')[0];
            const hargaJual = parseFloat(selectedOption.getAttribute('data-price')) || 0;

            fetch("{{ route('sales.check_safety') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ patient_id: patientId, medicine_id: medicineId })
            })
            .then(async res => {
                const text = await res.text();
                if (!res.ok) {
                    alert("RESPON ERROR SERVER:\n" + text);
                    throw new Error("Server error status: " + res.status);
                }
                try {
                    return JSON.parse(text);
                } catch (e) {
                    alert("Bukan JSON valid:\n" + text);
                    throw new Error("Respon server bukan JSON");
                }
            })
            .then(data => {
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

                if (data.status === 'danger') {
                    alertBox.classList.remove('hidden');
                    warningMsg.innerText = data.message;
                    cfValue.innerText = data.nilai_keyakinan;
                    rekomendasiText.innerText = data.rekomendasi;
                    badgeAlergi.classList.toggle('hidden', !data.risiko_alergi);

                    (data.risiko_efek_samping || []).forEach(r => {
                        efekTable.innerHTML += `
                            <tr class="border-t border-red-100">
                                <td class="px-2 py-1 font-semibold">${r.rule}</td>
                                <td class="px-2 py-1">${r.kategori_risiko}</td>
                                <td class="px-2 py-1">${r.keterangan}</td>
                                <td class="px-2 py-1 text-right">${(r.cf * 100).toFixed(0)}%</td>
                            </tr>`;
                    });

                    if(data.alternatives && data.alternatives.length > 0){
                        let altHTML = '<p class="text-xs font-bold text-gray-700">Rekomendasi Obat Pengganti yang Aman:</p>';
                        data.alternatives.forEach(alt => {
                            const safeName = (alt.nama_obat || alt.name || 'Obat Alternatif').replace(/'/g, "\\'");
                            const altHarga = parseFloat(alt.harga_jual || alt.price || 0);
                            const altId = alt.id_obat || alt.id;

                            altHTML += `
                                <div class="bg-white p-2 rounded border border-red-200 flex justify-between items-center text-xs">
                                    <div><strong>${safeName}</strong> (Rp ${altHarga.toLocaleString('id-ID')}) <span class="text-gray-400">| Efek: ${(alt.side_effects || []).join(', ')}</span></div>
                                    <button onclick="pilihAlternatif(${altId}, '${safeName}', ${altHarga})" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Gunakan Ini</button>
                                </div>`;
                        });
                        altList.innerHTML = altHTML;
                    } else {
                        altList.innerHTML = '<p class="text-xs text-gray-500">Tidak ada alternatif aman yang tersedia di gudang saat ini.</p>';
                    }
                } else {
                    safeBox.classList.remove('hidden');
                    document.getElementById('ai-safe-message').innerText = data.message;
                    tambahKeKeranjangLokal(medicineId, namaObat, hargaJual, qty);
                }
            })
            .catch(error => console.error(error));
        }

       function pilihAlternatif(id, nama, harga) {
            const selectObat = document.getElementById('kasir_medicine_id');
            
            let option = selectObat.querySelector(`option[value="${id}"]`);
            if (!option) {
                option = new Option(nama, id, true, true);
                option.setAttribute('data-price', harga);
                selectObat.add(option);
            }
            selectObat.value = id;
            
            const qty = parseInt(document.getElementById('kasir_qty').value) || 1;
            tambahKeKeranjangLokal(id, nama, harga, qty);
            
            document.getElementById('ai-alert-box').classList.add('hidden');
            
            selectObat.value = "";
            document.getElementById('kasir_qty').value = "1";
        }

        function tambahKeKeranjangLokal(id, nama, harga, qty) {
            const existingItem = keranjangItems.find(item => item.medicine_id == id);
            
            if (existingItem) {
                existingItem.quantity += qty;
            } else {
                keranjangItems.push({ medicine_id: id, name: nama, price: harga, quantity: qty });
            }
            
            renderTabelKeranjang();
        }

        function renderTabelKeranjang() {
            const tbody = document.getElementById('tabel-keranjang');
            if(keranjangItems.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">Keranjang masih kosong</td></tr>';
                return;
            }
            tbody.innerHTML = '';
            keranjangItems.forEach((item, index) => {
                let subtotal = item.price * item.quantity;
                tbody.innerHTML += `
                    <tr class="border-t">
                        <td class="px-4 py-2">${item.name}</td>
                        <td class="px-4 py-2 text-center">Rp ${item.price.toLocaleString('id-ID')}</td>
                        <td class="px-4 py-2 text-center">${item.quantity}</td>
                        <td class="px-4 py-2 text-right font-medium">Rp ${subtotal.toLocaleString('id-ID')}</td>
                        <td class="px-4 py-2 text-right"><button onclick="hapusItem(${index})" class="text-red-500 hover:underline">Hapus</button></td>
                    </tr>`;
            });
        }

        function hapusItem(index) {
            keranjangItems.splice(index, 1);
            renderTabelKeranjang();
        }

        function checkoutTransaksi() {
            if(keranjangItems.length === 0) return alert('Keranjang belanja kosong!');
            
            currentTotalBayar = keranjangItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            
            document.getElementById('modal-total-display').innerText = 'Rp ' + currentTotalBayar.toLocaleString('id-ID');
            document.getElementById('cash-given').value = '';
            document.getElementById('change-display').innerText = 'Rp 0';
            
            document.getElementById('modal-action-buttons').classList.remove('hidden');
            document.getElementById('success-action-section').classList.add('hidden');
            
            document.getElementById('checkout-modal').classList.remove('hidden');
        }

        function tutupModalCheckout() {
            document.getElementById('checkout-modal').classList.add('hidden');
        }

        function hitungKembalian() {
            const cash = parseFloat(document.getElementById('cash-given').value) || 0;
            const change = cash - currentTotalBayar;
            document.getElementById('change-display').innerText = change >= 0 ? 'Rp ' + change.toLocaleString('id-ID') : 'Uang kurang!';
        }

        function prosesSimpanCheckout() {
            const patientId = document.getElementById('kasir_patient_id').value;
            const paymentMethod = document.getElementById('payment-method').value;

            fetch("{{ route('sales.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    patient_id: patientId, 
                    items: keranjangItems,
                    payment_method: paymentMethod 
                })
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Terjadi kesalahan pada server.');
                return data;
            })
            .then(data => {
                if(data.status === 'success') {
                    lastInvoiceData = data;
                    document.getElementById('success-invoice').innerText = 'No. Nota: ' + data.invoice;
                    
                    document.getElementById('modal-action-buttons').classList.add('hidden');
                    document.getElementById('success-action-section').classList.remove('hidden');
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(err => alert('Gagal memproses checkout: ' + err.message));
        }

        function cetakStruk() {
            window.print();
        }

        function downloadPdf() {
            if(!lastInvoiceData) return alert('Data transaksi tidak ditemukan.');
            
            const saleId = lastInvoiceData.sale_id || lastInvoiceData.id;
            if (saleId) {
                window.open('/admin/sales/pdf/' + saleId, '_blank');
            } else {
                window.open('/admin/sales/pdf/invoice/' + encodeURIComponent(lastInvoiceData.invoice), '_blank');
            }
        }

        function resetTransaksiBaru() {
            keranjangItems = [];
            renderTabelKeranjang();
            tutupModalCheckout();
        }
    </script>
</body>
</html>