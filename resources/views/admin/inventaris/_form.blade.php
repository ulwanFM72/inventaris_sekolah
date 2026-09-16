@php
    // $barang: null saat mode tambah, instance Inventaris saat mode edit.
    // $formId: string unik supaya id elemen (datalist) tidak duplikat
    //          ketika partial ini dipakai berkali-kali di satu halaman
    //          (1x untuk modal Tambah, Nx untuk modal Edit per baris).
    $barang = $barang ?? null;
    $formId = $formId ?? 'create';
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
    <input type="text" name="jenis_barang" list="daftarJenisBarang-{{ $formId }}"
           class="form-control @error('jenis_barang') is-invalid @enderror"
           value="{{ old('jenis_barang', $barang->jenis_barang ?? '') }}" required>
    <datalist id="daftarJenisBarang-{{ $formId }}">
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

<div class="mb-1">
    <label class="form-label">Jumlah</label>
    <input type="number" name="jumlah" min="1" class="form-control @error('jumlah') is-invalid @enderror"
           value="{{ old('jumlah', $barang->jumlah ?? '') }}" required>
    @error('jumlah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
