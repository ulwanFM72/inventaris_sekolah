@php
    $barang = $barang ?? null;
@endphp

<div class="mb-3">
    <label class="form-label">Nama Barang</label>
    <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
           value="{{ old('nama_barang', $barang->nama_barang ?? '') }}" required>
    @error('nama_barang')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Jenis Barang</label>
    <input type="text" name="jenis_barang" list="daftarJenisBarang"
           class="form-control @error('jenis_barang') is-invalid @enderror"
           value="{{ old('jenis_barang', $barang->jenis_barang ?? '') }}" required>
    <datalist id="daftarJenisBarang">
        <option value="Elektronik">
        <option value="Furnitur">
        <option value="Alat Tulis Kantor">
        <option value="Alat Laboratorium">
        <option value="Alat Olahraga">
        <option value="Buku">
    </datalist>
    @error('jenis_barang')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
           value="{{ old('tanggal', isset($barang) ? $barang->tanggal->format('Y-m-d') : '') }}" required>
    @error('tanggal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kualitas</label>
    <select name="kualitas" class="form-select @error('kualitas') is-invalid @enderror" required>
        <option value="">-- Pilih Kualitas --</option>
        @foreach (\App\Models\Inventaris::KUALITAS_OPTIONS as $opsi)
            <option value="{{ $opsi }}" @selected(old('kualitas', $barang->kualitas ?? '') === $opsi)>{{ $opsi }}</option>
        @endforeach
    </select>
    @error('kualitas')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label">Jumlah</label>
    <input type="number" name="jumlah" min="1" class="form-control @error('jumlah') is-invalid @enderror"
           value="{{ old('jumlah', $barang->jumlah ?? '') }}" required>
    @error('jumlah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('admin.inventaris.index') }}" class="btn btn-outline-secondary">Batal</a>