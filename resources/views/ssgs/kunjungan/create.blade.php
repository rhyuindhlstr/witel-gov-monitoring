@extends('layouts.app')

@section('title', 'Tambah Interaksi')
@section('page-title', 'Tambah Interaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kunjungan.index') }}">Data Interaksi</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle text-danger me-2"></i>
                    Form Tambah Interaksi
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode Interaksi <span class="text-danger">*</span></label>
                        <select class="form-select @error('metode') is-invalid @enderror" id="metode" name="metode" required onchange="toggleHasilForm()">
                            <option value="">Pilih Metode Interaksi</option>
                            <option value="visit" {{ old('metode') == 'visit' ? 'selected' : '' }}>Kunjungan Langsung (Visit)</option>
                            <option value="call" {{ old('metode') == 'call' ? 'selected' : '' }}>Telepon (Call)</option>
                            <option value="whatsapp" {{ old('metode') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        </select>
                        @error('metode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="form-content" style="display:none">
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                            <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id" required>
                                <option value="">Pilih Pelanggan</option>
                                @foreach($pelanggans as $p)
                                    <option value="{{ $p->id }}" {{ (old('pelanggan_id') ?? $selectedPelanggan?->id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_pelanggan }} - {{ $p->nama_pic }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelanggan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggal_kunjungan" class="form-label">Tanggal Interaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_kunjungan') is-invalid @enderror" 
                                   id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required>
                            @error('tanggal_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan Interaksi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tujuan') is-invalid @enderror" 
                                   id="tujuan" name="tujuan" value="{{ old('tujuan') }}" 
                                   placeholder="Contoh: Follow-up pembayaran tagihan" required>
                            @error('tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- HASIL VISIT (TEXTAREA) --}}
                        <div class="mb-3 field-hasil" id="field-visit">
                            <label for="hasil_visit" class="form-label">Hasil Kunjungan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="hasil_visit" name="hasil_visit" rows="4">{{ old('hasil_visit') }}</textarea>
                            <small class="text-muted">Deskripsikan hasil pertemuan secara detail</small>
                        </div>

                        {{-- HASIL CALL (DROPDOWN) --}}
                        <div class="mb-3 field-hasil" id="field-call">
                            <label for="hasil_call" class="form-label">Status Panggilan <span class="text-danger">*</span></label>
                            <select class="form-select" id="hasil_call" name="hasil_call">
                                <option value="">Pilih Status Panggilan</option>
                                <option value="RNA">RNA (Ring No Answer)</option>
                                <option value="Sedang Sibuk">Sedang Sibuk</option>
                                <option value="Nomor tidak terdaftar">Nomor tidak terdaftar</option>
                                <option value="Sudah dibayarkan">Sudah dibayarkan</option>
                                <option value="Akan dibayarkan">Akan dibayarkan</option>
                                <option value="Tidak aktif">Tidak aktif</option>
                                <option value="Ingin pemutusan">Ingin pemutusan</option>
                                <option value="Sudah pemutusan">Sudah pemutusan</option>
                                <option value="Tidak dapat dihubungi">Tidak dapat dihubungi</option>
                            </select>
                        </div>

                        {{-- HASIL WA (DROPDOWN) --}}
                        <div class="mb-3 field-hasil" id="field-whatsapp">
                            <label for="hasil_whatsapp" class="form-label">Status WhatsApp <span class="text-danger">*</span></label>
                            <select class="form-select" id="hasil_whatsapp" name="hasil_whatsapp">
                                <option value="">Pilih Status WA</option>
                                <option value="Nomor tidak terdaftar">Nomor tidak terdaftar</option>
                                <option value="Sudah dibayarkan">Sudah dibayarkan</option>
                                <option value="Akan dibayarkan">Akan dibayarkan</option>
                                <option value="Ingin pemutusan">Ingin pemutusan</option>
                                <option value="Sudah pemutusan">Sudah pemutusan</option>
                                <option value="Minta keringanan pembayaran">Minta keringanan pembayaran</option>
                            </select>
                        </div>
                        
                        <div class="alert alert-info py-2">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Petugas: <strong>{{ Auth::user()->name }}</strong></small>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-telkom">
                                <i class="bi bi-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('kunjungan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                        </div>
                    </div>
                </form>

                <script>
                function toggleHasilForm() {
                    const metode = document.getElementById('metode').value;
                    const content = document.getElementById('form-content');
                    
                    if(!metode){
                        content.style.display = 'none';
                        return;
                    }
                    content.style.display = 'block';

                    // Hide all hasil fields
                    document.querySelectorAll('.field-hasil').forEach(el => el.style.display = 'none');
                    document.querySelectorAll('.field-hasil select, .field-hasil textarea').forEach(el => el.required = false);

                    // Show selected
                    const selectedField = document.getElementById('field-' + metode);
                    if(selectedField){
                        selectedField.style.display = 'block';
                        const input = selectedField.querySelector('select, textarea');
                        if(input) input.required = true;
                    }
                }
                // Run on load if old input exists
                document.addEventListener("DOMContentLoaded", function() {
                    toggleHasilForm();
                });
                </script>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-lightbulb text-warning me-2"></i>
                    Tips Pengisian
                </h6>
                <ul class="small mb-0">
                    <li>Pilih pelanggan yang diinteraksi</li>
                    <li>Catat tanggal interaksi secara akurat</li>
                    <li>Jelaskan tujuan interaksi dengan jelas</li>
                    <li>Untuk <strong>Call/WA</strong>, pilih status yang paling sesuai</li>
                    <li>Untuk <strong>Visit</strong>, jelaskan hasil pertemuan mendetail</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
