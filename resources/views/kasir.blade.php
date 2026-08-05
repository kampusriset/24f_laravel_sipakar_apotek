<<<<<<< HEAD
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Apotek Pintar</title>
    <!-- CSRF Token Meta Tag (Sangat Penting untuk Laravel) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm p-4">
        <h3 class="mb-4">🛒 Kasir Apotek Pintar</h3>
        
        <!-- Field Pilih Pasien -->
        <div class="form-group mb-3">
            <label for="patient_id" class="form-label fw-bold">Pilih Pasien:</label>
            <select id="patient_id" class="form-select">
                <option value="1">Budi Santoso (Alergi: Penisilin, Kondisi: Maag Kronis)</option>
            </select>
        </div>

        <!-- Field Pilih Obat -->
        <div class="form-group mb-3">
            <label for="medicine_id" class="form-label fw-bold">Pilih Obat:</label>
            <select id="medicine_id" class="form-select" onchange="cekKeamananObat()">
                <option value="">-- Pilih Obat --</option>
                <option value="1">Amoxicillin (Golongan: Penisilin)</option>
                <option value="2">Asam Mefenamat (Golongan: NSAID)</option>
                <option value="4">Paracetamol (Golongan: Anilin)</option>
            </select>
        </div>

        <!-- Alert Box AI untuk Peringatan & Rekomendasi -->
        <div id="ai-alert-box" class="alert alert-danger d-none mt-3">
            <h5 id="ai-warning-message" class="alert-heading"></h5>
            <div id="ai-alternatives-list" class="mt-2"></div>
        </div>
    </div>
</div>

<!-- JavaScript Engine -->
=======
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

>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
<script>
function cekKeamananObat() {
    const patientId = document.getElementById('patient_id').value;
    const medicineId = document.getElementById('medicine_id').value;
    const alertBox = document.getElementById('ai-alert-box');
    const warningMsg = document.getElementById('ai-warning-message');
    const altList = document.getElementById('ai-alternatives-list');

<<<<<<< HEAD
    // Jika dropdown diset kembali ke pilihan kosong
    if (!medicineId) {
        alertBox.classList.add('d-none');
        altList.innerHTML = '';
        return;
    }

    // Reset tampilan alert
    alertBox.classList.add('d-none');
    altList.innerHTML = '';

    // Ambil CSRF Token dari Meta Tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Kirim data ke Backend Laravel
=======
    if (!medicineId) return;

    // Sembunyikan alert box setiap kali memilih ulang
    alertBox.classList.add('d-none');
    altList.innerHTML = '';

    // Kirim data ke Route API Laravel yang kita buat kemarin
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
    fetch('/api/sales/check-safety', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
<<<<<<< HEAD
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
=======
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Keamanan Laravel
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
        },
        body: JSON.stringify({
            patient_id: patientId,
            medicine_id: medicineId
        })
    })
<<<<<<< HEAD
    .then(async response => {
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.message || 'Terjadi kesalahan pada server');
        }
        return data;
    })
    .then(data => {
        if (data.status === 'danger') {
            // 1. Tampilkan peringatan dari AI
            alertBox.classList.remove('d-none');
            warningMsg.innerText = data.message;

            // 2. Render alternatif obat jika ada
            if (data.alternatives && data.alternatives.length > 0) {
                let html = '<h6 class="mt-3 font-weight-bold">💡 Rekomendasi Obat Alternatif dari AI:</h6>';
                data.alternatives.forEach(alt => {
                    const sideEffects = Array.isArray(alt.side_effects) 
                        ? alt.side_effects.join(', ') 
                        : alt.side_effects;

                    const formattedPrice = Number(alt.price).toLocaleString('id-ID');

                    html += `
                        <div class="card p-3 mb-2 bg-white text-dark shadow-sm border">
                            <div><strong>${alt.name}</strong> - Rp ${formattedPrice}</div>
                            <small class="text-muted">Efek samping: ${sideEffects}</small>
                            <button type="button" class="btn btn-sm btn-success mt-2 w-100" onclick="gantiObat(${alt.id})">
=======
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
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
                                Pakai Obat Ini
                            </button>
                        </div>
                    `;
                });
<<<<<<< HEAD
                altList.innerHTML = html;
            } else {
                altList.innerHTML = '<p class="text-muted mt-2 mb-0">❌ Tidak ada alternatif yang cocok di gudang.</p>';
            }
        } else {
            // Jika obat aman digunakan
            alert('✅ Aman! Obat berhasil ditambahkan ke keranjang belanja.');
        }
    })
    .catch(error => {
        console.error('Error Check Safety:', error);
        alert('Gagal mengecek keamanan obat: ' + error.message);
    });
}

function gantiObat(alternativeId) {
    const selectMedicine = document.getElementById('medicine_id');
    const alertBox = document.getElementById('ai-alert-box');

    // Ubah nilai select box ke ID obat rekomendasi
    selectMedicine.value = alternativeId;

    // Sembunyikan alert box
    alertBox.classList.add('d-none');

    alert('Obat telah diganti dengan rekomendasi AI!');
}
</script>

</body>
</html>
=======
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
>>>>>>> 570f67c79d6ca1bc610c544f9bd93ffa410562e5
