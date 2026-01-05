@component('mail::message')

# Disposisi Pengajuan Baru

Anda menerima disposisi pengajuan dari **{{ $pengirim->username }}**.

---

## Detail Pengajuan
- **Nama Pemohon:** {{ $pengajuan->nama_pemohon }}
- **No. Permohonan:** {{ $pengajuan->no_permohonan }}
- **Jenis Izin:** {{ $pengajuan->tipe }}
- **Status Saat Ini:** {{ strtoupper($pengajuan->status) }}

---

@if($catatan)
### Catatan Disposisi:
> {{ $catatan ?? "" }}
@endif

---

@component('mail::button', ['url' => url('/ciptakarya/list-data-pbg?pengajuan='.$pengajuan->id)])
Lihat Pengajuan
@endcomponent

Terima kasih,  
**{{ config('app.name') }}**

@endcomponent
