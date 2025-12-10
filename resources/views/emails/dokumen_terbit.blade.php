@component('mail::message')

# Dokumen Telah Diterbitkan

Halo,

Pengajuan berikut telah **berhasil diterbitkan**:

---

### Detail Pengajuan
- **Nama Pemohon:** {{ $pengajuan->nama_pemohon }}
- **No. Permohonan:** {{ $pengajuan->no_permohonan }}
- **Jenis Izin:** {{ $pengajuan->tipe }}
- **Tanggal Terbit:** {{ $pengajuan->tgl_terbit ?? now() }}

---

@component('mail::button', ['url' => url('/ciptakarya/list-data-pbg?pengajuan='.$pengajuan->id)])
Lihat Dokumen
@endcomponent

Terima kasih,  
**{{ config('app.name') }}**

@endcomponent
