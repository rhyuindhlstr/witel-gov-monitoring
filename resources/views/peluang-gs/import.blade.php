@extends('layouts.gs')

@section('title', 'Import Peluang Proyek GS')

@section('content')

{{-- NOTIFIKASI SUKSES (dari redirect setelah berhasil di halaman lain - fallback) --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Import Berhasil!',
            html: '<p style="font-size:15px">{{ session("success") }}</p>',
            timer: 3500,
            showConfirmButton: false,
            timerProgressBar: true,
        });
    });
</script>
@endif

{{-- NOTIFIKASI GAGAL --}}
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Import Gagal!',
            html: `<div style="font-size:13px;text-align:left;background:#fff5f5;border-radius:8px;padding:12px;line-height:1.7;word-break:break-all;">
                        {!! nl2br(e(session('error'))) !!}
                   </div>`,
            confirmButtonColor: '#b30000',
            confirmButtonText: 'Tutup',
            width: 560,
        });
    });
</script>
@endif

{{-- VALIDASI ERROR --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'warning',
            title: 'Periksa File Anda',
            html: '<ul style="text-align:left;font-size:14px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>',
            confirmButtonColor: '#b30000',
            confirmButtonText: 'OK',
        });
    });
</script>
@endif

{{-- HEADER --}}
<div class="card mb-4 shadow"
     style="background:linear-gradient(135deg,#b30000,#ff1a1a);color:white;border:none;border-radius:14px;">
    <div class="card-body d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-file-earmark-spreadsheet" style="font-size:24px;"></i>
        </div>
        <div>
            <h4 class="fw-bold mb-0">Import Data Peluang Proyek GS</h4>
            <small style="opacity:.85;">Upload file Excel untuk menambahkan data peluang proyek secara massal</small>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- FORM UPLOAD --}}
    <div class="col-lg-7">
        <div class="card shadow-sm border-0" style="border-radius:14px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color:#b30000;">
                    <i class="bi bi-upload me-2"></i>Upload File
                </h6>

                <form action="{{ route('peluang-gs.import') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      id="importForm">
                    @csrf

                    {{-- DROP ZONE --}}
                    <div id="dropZone"
                         onclick="document.getElementById('fileInput').click()"
                         style="border:2px dashed #dee2e6;border-radius:12px;padding:40px 24px;text-align:center;cursor:pointer;transition:all .2s;background:#fafbfc;">
                        <i class="bi bi-cloud-upload" style="font-size:40px;color:#adb5bd;"></i>
                        <p class="mt-2 mb-1 fw-semibold" style="color:#495057;">Klik atau drag & drop file di sini</p>
                        <p class="mb-0" style="font-size:13px;color:#adb5bd;">.xlsx, .xls, .csv — Maks. 10MB</p>
                    </div>

                    <input type="file" id="fileInput" name="file"
                           class="d-none" accept=".xlsx,.xls,.csv"
                           onchange="handleFileChange(this)">

                    {{-- PREVIEW FILE TERPILIH --}}
                    <div id="filePreview" class="mt-3" style="display:none;">
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                            <i class="bi bi-file-earmark-excel-fill" style="font-size:28px;color:#16a34a;flex-shrink:0;"></i>
                            <div style="flex:1;min-width:0;">
                                <div id="fileName" class="fw-semibold" style="color:#15803d;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></div>
                                <div id="fileSize" style="font-size:12px;color:#86efac;"></div>
                            </div>
                            <button type="button" onclick="clearFile()"
                                    style="background:none;border:none;color:#dc2626;padding:4px;cursor:pointer;"
                                    title="Hapus file">
                                <i class="bi bi-x-circle-fill" style="font-size:18px;"></i>
                            </button>
                        </div>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('peluang-gs.index') }}"
                           class="btn btn-outline-secondary"
                           style="border-radius:10px;padding:10px 20px;">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" id="submitBtn"
                                class="btn btn-success"
                                style="border-radius:10px;padding:10px 28px;font-weight:600;min-width:150px;">
                            <span id="btnText"><i class="bi bi-file-earmark-arrow-up me-2"></i>Import Data</span>
                            <span id="btnLoading" style="display:none;">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span> Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- PANDUAN KOLOM --}}
    <div class="col-lg-5">
        <div class="card shadow-sm border-0" style="border-radius:14px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color:#b30000;">
                    <i class="bi bi-info-circle me-2"></i>Panduan Kolom Header
                </h6>
                <div style="font-size:13px;">
                    @php
                    $columns = [
                        ['wilayah_id',           'ID wilayah dari tabel wilayah GS',              'required'],
                        ['id_am',                'Kode Account Manager',                           'optional'],
                        ['nama_am',              'Nama Account Manager',                           'optional'],
                        ['nama_gc',              'Nama Government Customer',                       'optional'],
                        ['satker',               'Nama Instansi / Satuan Kerja',                  'optional'],
                        ['judul_proyek',         'Nama / judul proyek',                           'required'],
                        ['jenis_layanan',        'Konektivitas / Cloud / Digital / dll',          'optional'],
                        ['jenis_proyek',         'CAPEX atau OPEX',                               'optional'],
                        ['nilai_estimasi',       'Angka estimasi (tanpa titik/koma)',              'optional'],
                        ['nilai_realisasi',      'Angka realisasi',                               'optional'],
                        ['nilai_scaling',        'Angka scaling',                                 'optional'],
                        ['status_mytens',        'YES atau NO',                                   'optional'],
                        ['status_proyek',        'PROSPECT / WIN / LOSE / CANCEL / KEGIATAN_VALID','optional'],
                        ['mekanisme_pengadaan',  'Langsung atau Tender',                          'optional'],
                        ['start_pelaksanaan',    'Format: 2025-01-15',                            'optional'],
                        ['end_pelaksanaan',      'Format: 2025-12-31',                            'optional'],
                        ['keterangan',           'Catatan tambahan (bebas)',                      'optional'],
                    ];
                    @endphp
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:#fff5f5;">
                                <th style="padding:8px 10px;color:#b30000;font-weight:700;border-bottom:2px solid #fecaca;">Kolom</th>
                                <th style="padding:8px 10px;color:#b30000;font-weight:700;border-bottom:2px solid #fecaca;">Keterangan</th>
                                <th style="padding:8px 10px;text-align:center;color:#b30000;font-weight:700;border-bottom:2px solid #fecaca;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($columns as [$col, $desc, $req])
                            <tr style="border-bottom:1px solid #f1f3f5;">
                                <td style="padding:6px 10px;font-family:monospace;font-size:12px;color:#6d28d9;white-space:nowrap;">{{ $col }}</td>
                                <td style="padding:6px 10px;color:#6b7280;">{{ $desc }}</td>
                                <td style="padding:6px 10px;text-align:center;">
                                    @if($req === 'required')
                                        <span style="background:#fee2e2;color:#b91c1c;font-size:11px;font-weight:700;padding:2px 7px;border-radius:20px;">Wajib</span>
                                    @else
                                        <span style="background:#f3f4f6;color:#9ca3af;font-size:11px;padding:2px 7px;border-radius:20px;">Opsional</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- ID WILAYAH YANG VALID --}}
                    <div class="mt-3 p-3" style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;">
                        <div class="fw-bold mb-2" style="color:#92400e;font-size:13px;">
                            <i class="bi bi-geo-alt-fill me-1"></i> Wilayah ID yang valid:
                        </div>
                        @foreach(App\Models\WilayahGS::orderBy('id')->get() as $w)
                            <span style="display:inline-block;background:white;border:1px solid #fcd34d;border-radius:6px;padding:2px 10px;margin:2px;font-size:12px;color:#78350f;">
                                <strong>{{ $w->id }}</strong> = {{ $w->nama_wilayah }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
// ── Drag & Drop ──────────────────────────────────────────────────────────────
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');

dropZone.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.style.borderColor = '#b30000';
    dropZone.style.background  = '#fff5f5';
});
dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = '#dee2e6';
    dropZone.style.background  = '#fafbfc';
});
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.style.borderColor = '#dee2e6';
    dropZone.style.background  = '#fafbfc';
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        handleFileChange(fileInput);
    }
});

// ── File preview ─────────────────────────────────────────────────────────────
function handleFileChange(input) {
    if (!input.files.length) return;
    const file = input.files[0];
    const ext  = file.name.split('.').pop().toLowerCase();
    const allowed = ['xlsx', 'xls', 'csv'];

    if (!allowed.includes(ext)) {
        Swal.fire({
            icon: 'warning',
            title: 'Format tidak didukung',
            text: 'Hanya file .xlsx, .xls, atau .csv yang diperbolehkan.',
            confirmButtonColor: '#b30000',
        });
        clearFile();
        return;
    }

    document.getElementById('fileName').textContent = file.name;
    document.getElementById('fileSize').textContent  = formatBytes(file.size);
    document.getElementById('filePreview').style.display = 'block';
    dropZone.style.borderColor = '#16a34a';
    dropZone.style.background  = '#f0fdf4';
}

function clearFile() {
    fileInput.value = '';
    document.getElementById('filePreview').style.display = 'none';
    dropZone.style.borderColor = '#dee2e6';
    dropZone.style.background  = '#fafbfc';
}

function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(2) + ' MB';
}

// ── Loading state saat submit ──────────────────────────────────────────────
document.getElementById('importForm').addEventListener('submit', function (e) {
    if (!fileInput.files.length) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'File belum dipilih',
            text: 'Pilih file Excel terlebih dahulu sebelum mengimport.',
            confirmButtonColor: '#b30000',
        });
        return;
    }
    document.getElementById('btnText').style.display    = 'none';
    document.getElementById('btnLoading').style.display = 'inline-flex';
    document.getElementById('submitBtn').disabled = true;
});
</script>

@endsection
