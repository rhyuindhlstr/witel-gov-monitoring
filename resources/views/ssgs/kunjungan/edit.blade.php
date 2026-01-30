@extends('layouts.app')

@section('title', 'Edit Interaksi')
@section('page-title', 'Edit Interaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ssgs') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kunjungan.index') }}">Data Interaksi</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil text-warning me-2"></i>
                    Form Edit Interaksi
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kunjungan.update', $kunjungan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode Interaksi <span class="text-danger">*</span></label>
                        <select class="form-select @error('metode') is-invalid @enderror" id="metode" name="metode" required onchange="toggleHasilForm()">
                            <option value="">Pilih Metode Interaksi</option>
                            <option value="visit" {{ old('metode', $kunjungan->metode) == 'visit' ? 'selected' : '' }}>Kunjungan Langsung (Visit)</option>
                            <option value="call" {{ old('metode', $kunjungan->metode) == 'call' ? 'selected' : '' }}>Telepon (Call)</option>
                            <option value="whatsapp" {{ old('metode', $kunjungan->metode) == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
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
                                    <option value="{{ $p->id }}" {{ old('pelanggan_id', $kunjungan->pelanggan_id) == $p->id ? 'selected' : '' }}>
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
                                   id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $kunjungan->tanggal_kunjungan->format('Y-m-d')) }}" required>
                            @error('tanggal_kunjungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan Interaksi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tujuan') is-invalid @enderror" 
                                   id="tujuan" name="tujuan" value="{{ old('tujuan', $kunjungan->tujuan) }}" required>
                            @error('tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- HASIL VISIT (TEXTAREA) --}}
                        <div class="mb-3 field-hasil" id="field-visit">
                            <label for="hasil_visit" class="form-label">Hasil Kunjungan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="hasil_visit" name="hasil_visit" rows="4">{{ old('hasil_visit', $kunjungan->metode == 'visit' ? $kunjungan->hasil_kunjungan : '') }}</textarea>
                            <small class="text-muted">Deskripsikan hasil pertemuan secara detail</small>
                        </div>

                        {{-- HASIL CALL (DROPDOWN) --}}
                        <div class="mb-3 field-hasil" id="field-call">
                            <label for="hasil_call" class="form-label">Status Panggilan <span class="text-danger">*</span></label>
                            <select class="form-select" id="hasil_call" name="hasil_call">
                                <option value="">Pilih Status Panggilan</option>
                                @foreach(['RNA','Sedang Sibuk','Nomor tidak terdaftar','Sudah dibayarkan','Akan dibayarkan','Tidak aktif','Ingin pemutusan','Sudah pemutusan','Tidak dapat dihubungi'] as $status)
                                    <option value="{{ $status }}" {{ old('hasil_call', $kunjungan->metode == 'call' ? $kunjungan->hasil_kunjungan : '') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- HASIL WA (DROPDOWN) --}}
                        <div class="mb-3 field-hasil" id="field-whatsapp">
                            <label for="hasil_whatsapp" class="form-label">Status WhatsApp <span class="text-danger">*</span></label>
                            <select class="form-select" id="hasil_whatsapp" name="hasil_whatsapp">
                                <option value="">Pilih Status WA</option>
                                @foreach(['Nomor tidak terdaftar','Sudah dibayarkan','Akan dibayarkan','Ingin pemutusan','Sudah pemutusan','Minta keringanan pembayaran'] as $status)
                                    <option value="{{ $status }}" {{ old('hasil_whatsapp', $kunjungan->metode == 'whatsapp' ? $kunjungan->hasil_kunjungan : '') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-telkom">
                                <i class="bi bi-save me-2"></i>Update
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
                // Run on load to show current state
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
                    <i class="bi bi-person text-info me-2"></i>
                    Petugas
                </h6>
                <p class="mb-0"><strong>{{ $kunjungan->user->name }}</strong></p>
                <hr>
                <p class="small text-muted mb-1">Dibuat: {{ $kunjungan->created_at->format('d M Y H:i') }}</p>
                <p class="small text-muted mb-0">Diupdate: {{ $kunjungan->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
