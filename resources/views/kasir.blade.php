<div class="container mt-5">
    <h3>🛒 Kasir Apotek Pintar</h3>
    
    <div class="form-group mb-3">
        <label>Pilih Pasien:</label>
        <select id="patient_id" class="form-control">
            <option value="1">Budi Santoso (Alergi: Penisilin, Kondisi: Maag Kronis)</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label>Pilih Obat:</label>
        <select id="medicine_id" class="form-control" onchange="cekKeamananObat()">
            <option value="">-- Pilih Obat --</option>
            <option value="1">Amoxicillin (Golongan: Penisilin)</option>
            <option value="2">Asam Mefenamat (Golongan: NSAID)</option>
            <option value="4">Paracetamol (Golongan: Anilin)</option>
        </select>
    </div>

    <div id="ai-alert-box" class="alert alert-danger d-none mt-3">
        <h5 id="ai-warning-message"></h5>
        <div id="ai-alternatives-list" class="mt-2"></div>
    </div>
</div>

<script>
function cekKeamananObat() {
    const patientId = document.getElementById('patient_id').value;
    const medicineId = document.getElementById('medicine_id').value;
    const alertBox = document.getElementById('ai-alert-box');
    const warningMsg = document.getElementById('ai-warning-message');
    const altList = document.getElementById('ai-alternatives-list');

    if (!medicineId) return;

    // Sembunyikan alert box setiap kali memilih ulang
    alertBox.classList.add('d-none');
    altList.innerHTML = '';

    // Kirim data ke Route API Laravel yang kita buat kemarin
    fetch('/api/sales/check-safety', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Keamanan Laravel
        },
        body: JSON.stringify({
            patient_id: patientId,
            medicine_id: medicineId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'danger') {
            // 1. Tampilkan pesan bahaya dari AI
            alertBox.classList.remove('d-none');
            warningMsg.innerText = data.message;

            // 2. Tampilkan daftar obat alternatif yang direkomendasikan AI
            if (data.alternatives.length > 0) {
                altList.innerHTML = '<h6>💡 Rekomendasi Obat Alternatif dari AI:</h6>';
                data.alternatives.forEach(alt => {
                    altList.innerHTML += `
                        <div class="card p-2 mb-2 bg-light">
                            <strong>${alt.name}</strong> - Rp ${alt.price}<br>
                            <small class="text-muted">Efek samping: ${alt.side_effects.join(', ')}</small>
                            <button class="btn btn-sm btn-success mt-1" onclick="gantiObat(${alt.id})">
                                Pakai Obat Ini
                            </button>
                        </div>
                    `;
                });
            } else {
                altList.innerHTML = '<p class="text-muted">❌ Tidak ada alternatif yang cocok di gudang.</p>';
            }
        } else {
            // Jika status 'safe' (Aman), langsung masukkan ke keranjang belanja POS
            alert('✅ Aman! Obat berhasil ditambahkan ke keranjang belanja.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function gantiObat(alternativeId) {
    // Fungsi untuk otomatis mengubah pilihan select box kasir ke obat rekomendasi AI
    document.getElementById('medicine_id').value = alternativeId;
    document.getElementById('ai-alert-box').classAdd('d-none');
    alert('Obat telah diganti dengan rekomendasi AI!');
}
</script>