@extends('layouts.app')
@section('title', 'Detail Pengajuan PBG / SLF')

@section('css')
<style>
    .detail-box {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        background: #fff;
    }

    .detail-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #eee;
    }

    .detail-item {
        margin-bottom: 10px;
    }

    .detail-item b {
        width: 220px;
        display: inline-block;
    }

    .foto-item {
        width: 220px;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .timeline-box {
        background: #fafafa;
        border-left: 4px solid #f4c542;
        padding: 12px 18px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .detail-box textarea {
        border-radius: 6px;
    }

    .detail-box input[type=radio] {
        transform: scale(1.2);
        margin-right: 5px;
    }

    #btn_simpan_verifikasi {
        background: linear-gradient(45deg, #28a745, #1e8f3f);
        box-shadow: 0 4px 12px rgba(0, 150, 60, 0.4);
        border: none;
        transition: 0.2s;
    }

    #btn_simpan_verifikasi:hover {
        background: linear-gradient(45deg, #2fd150, #25a440);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 150, 60, 0.6);
    }

/* --- Modern admin cards & foto (kuning pastel theme) --- */
    :root {
        --card-bg: #fff7e6; /* kuning pastel */
        --card-border: #f0dba8;
        --muted: #6b7280;
        --success: #16a34a;
        --danger: #dc2626;
        --radius: 10px;
        --shadow-sm: 0 6px 18px rgba(20,20,20,0.06);
    }

    /* Container adjustments (in case parent has white bg) */
    .detail-box {
        background: linear-gradient(180deg, #ffffff 0%, #fffdf8 100%);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
    }

    /* FOTO GRID */
    .foto-grid-admin {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); /* responsive: 3-4 columns */
        gap: 16px;
        align-items: start;
        margin-top: 8px;
    }

    .foto-card {
        background: var(--card-bg);
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        transition: transform .18s ease, box-shadow .18s ease;
        display: flex;
        flex-direction: column;
    }

    .foto-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.09);
    }

    .foto-thumb {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        display: block;
    }

    .foto-meta {
        padding: 10px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .foto-caption {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #333;
    }

    .foto-sub {
        font-size: 12px;
        color: var(--muted);
    }

    .foto-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-action {
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 6px;
        border-radius: 8px;
    }

    .btn-action:hover { background: rgba(0,0,0,0.04); }

    /* ===== Hasil Pemeriksaan (Ringkas) modern cards ===== */
    .answers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 14px;
        margin-top: 10px;
    }

    .answer-card {
        background: #fff;
        border-left: 6px solid var(--card-border);
        padding: 12px;
        border-radius: 8px;
        box-shadow: 0 6px 18px rgba(10,10,10,0.03);
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .answer-card .meta {
        flex: 1;
    }

    .answer-title {
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 14px;
        color: #111827;
    }

    .answer-value {
        font-size: 13px;
        color: var(--muted);
    }

    .answer-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(0,0,0,0.03);
    }

    .answer-icon.success {
        color: var(--success);
        background: rgba(22,163,74,0.08);
    }

    .answer-icon.danger {
        color: var(--danger);
        background: rgba(220,38,38,0.08);
    }

    .answer-icon.neutral {
        color: #6b7280;
        background: rgba(107,114,128,0.06);
    }

    /* small screens adjustments */
    @media (max-width: 600px) {
        .detail-box { padding: 14px; }
        .foto-grid-admin { gap: 10px; }
    }

    /* Lightbox modal (simple) */
    .img-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1200;
    }

    .img-modal {
        max-width: 95%;
        max-height: 90%;
        border-radius: 8px;
        overflow: hidden;
        background: #111;
    }

    .img-modal img { width: 100%; height: auto; display: block; }

    .img-modal-close {
        position: absolute;
        top: 18px;
        right: 18px;
        background: rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 6px;
        cursor: pointer;
        color: white;
        border: none;
    }

</style>
<style>
.section-title {
    font-size: 16px;
    font-weight: bold;
    margin: 15px 0 8px;
    padding-bottom: 4px;
    border-bottom: 2px solid #eee;
}

.sub-title {
    font-size: 15px;
    font-weight: bold;
    margin: 10px 0 5px;
    padding-left: 10px;
}

.sub-title-2 {
    font-size: 14px;
    font-weight: bold;
    margin: 8px 0 5px;
    padding-left: 20px;
}

.table-simple {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

.table-simple td {
    border: 1px solid #ddd;
    padding: 6px 10px;
    font-size: 13px;
}

.answer-yes {
    color: #0a7c32;
    font-weight: bold;
}

.answer-no {
    color: #c0392b;
    font-weight: bold;
}
</style>
@endsection

@section('content')

<section class="content-header">
    <h1>Detail Pengajuan</h1>
</section>

<section class="content row">

    <div class="detail-box col-md-12">
        <div class="detail-title">Verifikasi Berkas</div>

        <input type="hidden" id="pengajuan_id" value="{{ $pengajuan['id'] }}">

        <div class="detail-title">Riwayat Verifikasi</div>

        <div id="riwayat_verifikasi_list">
            <div class="text-muted">Memuat riwayat...</div>
        </div>

        <div class="form-group detail-item">
            <b>Keterangan / Catatan:</b>
            <textarea id="catatan_verifikasi" class="form-control" 
            rows="3"
            placeholder="Tuliskan catatan atau keterangan pemeriksaan..."></textarea>
        </div>

        <div class="form-group detail-item">
            <b>Hasil Verifikasi:</b><br>

            <label style="margin-right:20px;">
                <input type="radio" name="hasil_verifikasi" value="sesuai">
                <span class="text-success"><b>Sesuai</b></span>
            </label>

            <label>
                <input type="radio" name="hasil_verifikasi" value="tidak_sesuai">
                <span class="text-danger"><b>Tidak Sesuai</b></span>
            </label>
        </div>

        <!-- 🔥 TOMBOL SIMPAN BARU -->
        <div class="text-right mt-3">
            <button id="btn_simpan_verifikasi" class="btn btn-lg btn-success"
                style="padding: 12px 30px; font-size: 18px; font-weight:bold; border-radius:10px;">
                <i class="fa fa-save"></i> SIMPAN VERIFIKASI
            </button>
        </div>

    </div>

    <div class="detail-box col-md-12">
        <div class="detail-title">Informasi Umum</div>

        <div class="detail-item"><b>Nama Pemohon:</b> {{ $pengajuan['nama_pemohon'] }}</div>
        <div class="detail-item"><b>NIK:</b> {{ $pengajuan['nik'] }}</div>
        <div class="detail-item"><b>Alamat Pemohon:</b> {{ $pengajuan['alamat'] }}</div>

        <div class="detail-item"><b>No. Permohonan:</b> {{ $pengajuan['no_permohonan'] }}</div>
        <div class="detail-item"><b>Jenis Izin:</b> {{ $pengajuan['tipe'] }}</div>
        <div class="detail-item"><b>Status:</b> 
            @php
                $color = $pengajuan['status'] == 'terbit' ? 'green' : ($pengajuan['status'] == 'gagal' ? 'red' : 'blue');
            @endphp
            <span class="badge bg-{{ $color }}">{{ strtoupper($pengajuan['status']) }}</span>
        </div>
        <div class="detail-item"><b>Tanggal Input:</b> {{ $pengajuan['created_at'] }}</div>
        <div class="detail-item"><b>Petugas Lapangan:</b> 
            {{ $pengajuan['petugas_lapangan']['nama'] ?? '-' }}
        </div>
        <div class="detail-item"><b>Nama Bangunan:</b> {{ $pengajuan['nama_bangunan'] }}</div>
        <div class="detail-item"><b>Fungsi:</b> {{ $pengajuan['fungsi_bangunan'] }}</div>
        <div class="detail-item"><b>Jumlah Bangunan:</b> {{ $pengajuan['jumlah_bangunan'] }}</div>
        <div class="detail-item"><b>Jumlah Lantai:</b> {{ $pengajuan['jumlah_lantai'] }}</div>
        <div class="detail-item"><b>Luas Bangunan:</b> {{ $pengajuan['luas_bangunan'] }}</div>
        <div class="detail-item"><b>Ketinggian:</b> {{ $pengajuan['ketinggian_bangunan'] }}</div>
        <div class="detail-item"><b>Lokasi Bangunan:</b> {{ $pengajuan['lokasi_bangunan'] }}</div>
        <div class="detail-item"><b>No. Persil:</b> {{ $pengajuan['no_persil'] }}</div>
        <div class="detail-item"><b>Luas Tanah:</b> {{ $pengajuan['luas_tanah'] }}</div>
        <div class="detail-item"><b>Pemilik Tanah:</b> {{ $pengajuan['pemilik_tanah'] }}</div>
        <div class="detail-item"><b>KDB Maksimum:</b> {{ $pengajuan['kdb_max'] }}</div>
        <div class="detail-item"><b>KDH Minimum:</b> {{ $pengajuan['kdh_min'] }}</div>
        <div class="detail-item"><b>GBS Minimum:</b> {{ $pengajuan['gbs_min'] }}</div>
        <div class="detail-item"><b>Koordinat:</b> {{ $pengajuan['koordinat_bangunan'] }}</div>
    </div>

    <div class="detail-box col-md-12">
        <div class="detail-title">Foto Lapangan</div>

        @php
            $fotos = json_decode($pengajuan['list_foto'] ?? "[]", true);
            // if(count($fotos) > 0)
            // $fotos = array_slice($fotos, 0, 10); // ambil 10 item pertama
        @endphp

        @if($fotos && count($fotos) > 0)
            <div class="foto-grid-admin">
                @foreach ($fotos as $idx => $foto)
                    <div class="foto-card" data-index="{{ $idx }}">
                        <img
                            src="{{ $foto['url'] }}"
                            alt="{{ $foto['caption'] ?? 'Foto lapangan' }}"
                            class="foto-thumb"
                            loading="lazy"
                            data-full="{{ $foto['url'] }}"
                        >
                        <div class="foto-meta">
                            <div>
                                <div class="foto-caption">{{ $foto['caption'] ?? 'Tanpa caption' }}</div>
                                @if(!empty($foto['note']))
                                    <div class="foto-sub">{{ $foto['note'] }}</div>
                                @endif
                            </div>

                            <div class="foto-actions">
                                <button type="button" class="btn-action btn-preview" title="Pratinjau" data-src="{{ $foto['url'] }}">
                                    <!-- inline SVG preview icon -->
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 5C7 5 2.73 8.11 1 12C2.73 15.89 7 19 12 19C17 19 21.27 15.89 23 12C21.27 8.11 17 5 12 5Z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.2"/>
                                    </svg>
                                </button>

                                <a href="{{ $foto['url'] }}" target="_blank" class="btn-action" title="Buka di tab baru">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 3H21V10" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10 14L21 3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21 21H3V3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div>Tidak ada foto.</div>
        @endif
    </div>

    <div class="detail-box col-md-12">
        <div class="detail-title">Hasil Pemeriksaan</div>
        @if(count($inspectionResults) == 0)
            <div>Tidak ada hasil.</div>
        @else
            @foreach($inspectionResults as $section)
                
                <div class="section-title">
                    {{ $section['caption'] }}
                </div>

                {{-- LEVEL 1 --}}
                @if(count($section['rows']))
                    <table class="table-simple">
                        <tbody>
                            @foreach($section['rows'] as $row)
                                <tr>
                                    <td width="70%">{{ $row['question'] }}</td>
                                    <td width="30%">
                                        <span class="{{ in_array($row['answer'], ['Ya','Ada','Sesuai']) ? 'answer-yes' : 'answer-no' }}">
                                            {{ $row['answer'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif


                {{-- LEVEL 2 --}}
                @foreach($section['child'] as $child1)

                    <div class="sub-title">
                        {{ $child1['caption'] }}
                    </div>

                    @if(count($child1['rows']))
                        <table class="table-simple">
                            <tbody>
                                @foreach($child1['rows'] as $row)
                                    <tr>
                                        <td width="70%" style="padding-left: 20px;">
                                            {{ $row['question'] }}
                                        </td>
                                        <td width="30%">
                                            <span class="{{ in_array($row['answer'], ['Ya','Ada','Sesuai']) ? 'answer-yes' : 'answer-no' }}">
                                                {{ $row['answer'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif


                    {{-- LEVEL 3 --}}
                    @foreach($child1['child'] as $child2)

                        <div class="sub-title-2">
                            {{ $child2['caption'] }}
                        </div>

                        <table class="table-simple">
                            <tbody>
                                @foreach($child2['rows'] as $row)
                                    <tr>
                                        <td width="70%" style="padding-left: 35px;">
                                            {{ $row['question'] }}
                                        </td>
                                        <td width="30%">
                                            <span class="{{ in_array($row['answer'], ['Ya','Ada','Sesuai']) ? 'answer-yes' : 'answer-no' }}">
                                                {{ $row['answer'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endforeach

                @endforeach

            @endforeach
        @endif
    </div>

    


</section>

@endsection

@section('javascript')
<script>
    // --- Lightbox / preview untuk foto ---
    (function() {
        // buat elemen modal di body
        const modalTpl = document.createElement('div');
        modalTpl.className = 'img-modal-backdrop';
        modalTpl.innerHTML = `
            <div class="img-modal" role="dialog" aria-modal="true">
                <button class="img-modal-close" title="Tutup">&times;</button>
                <img src="" alt="Preview">
            </div>
        `;
        document.body.appendChild(modalTpl);

        const backdrop = modalTpl;
        const imgEl = backdrop.querySelector('img');
        const btnClose = backdrop.querySelector('.img-modal-close');

        // open modal
        function openModal(src, alt) {
            imgEl.src = src;
            imgEl.alt = alt || 'Foto';
            backdrop.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // close modal
        function closeModal() {
            backdrop.style.display = 'none';
            imgEl.src = '';
            document.body.style.overflow = '';
        }

        // event delegates
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-preview');
            if (target) {
                e.preventDefault();
                const src = target.getAttribute('data-src') || target.dataset.src;
                openModal(src, 'Preview Foto');
                return;
            }
        });

        btnClose.addEventListener('click', closeModal);
        backdrop.addEventListener('click', function(ev) {
            if (ev.target === backdrop) closeModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    })();
</script>
<script>
    // ---- Helper: tampilkan pesan error field ----
    function showValidationErrors(errors) {
        if (!errors) return;
        let msgs = [];
        if (typeof errors === 'object') {
            Object.keys(errors).forEach(k => {
                if (Array.isArray(errors[k])) msgs.push(...errors[k]);
                else msgs.push(errors[k]);
            });
        } else {
            msgs.push(errors);
        }
        toastr.error(msgs.join("\n"));
    }

    function loadRiwayat() {
        const id = $('#pengajuan_id').val();

        $.get("{{ route('ciptakarya.riwayatVerifikasi', ['id' => '__ID__']) }}".replace('__ID__', id), 
        function(res) {
            if (!res.status) return;

            let html = "";

            if (res.data.length === 0) {
                html = `<div class="text-muted">Belum ada riwayat verifikasi.</div>`;
            } else {
                res.data.forEach(item => {
                    const statusColor = item.status === 'approved' ? '#16a34a'
                                    : item.status === 'rejected' ? '#dc2626'
                                    : '#6b7280';

                    html += `
                        <div class="timeline-box" style="margin-bottom:12px;">
                            <div><b>${item.role}</b> <span style="color:#888">(${item.verified_at})</span></div>
                            <div><b>Status:</b> <span style="color:${statusColor};text-transform:uppercase">${item.status}</span></div>
                            <div><b>Oleh:</b> ${item.user}</div>
                            ${
                                item.catatan 
                                    ? `<div><b>Catatan:</b> ${item.catatan}</div>`
                                    : ``
                            }
                        </div>
                    `;
                });
            }

            $('#riwayat_verifikasi_list').html(html);
        });
    }


    // ---- AJAX Simpan Verifikasi ----
    $('#btn_simpan_verifikasi').off('click').on('click', function(e) {
        e.preventDefault();

        const catatan = $('#catatan_verifikasi').val();
        const hasil = $('input[name="hasil_verifikasi"]:checked').val(); // 'sesuai' / 'tidak_sesuai'
        const pengajuan_id = $('#pengajuan_id').val();

        if (!hasil) {
            return toastr.warning("Pilih hasil verifikasi terlebih dahulu!");
        }

        // Disable tombol sementara
        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: "{{ route('ciptakarya.simpanVerifikasi') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                pengajuan_id: pengajuan_id,
                hasil: hasil,
                catatan: catatan
            },
            success: function(res) {
                if (res.status) {
                    toastr.success(res.message || "Verifikasi berhasil disimpan!");
                    loadRiwayat();
                } else {
                    toastr.error(res.message || "Gagal menyimpan verifikasi!");
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON) {
                    // Laravel validation error
                    showValidationErrors(xhr.responseJSON.errors || xhr.responseJSON);
                } else {
                    toastr.error("Terjadi kesalahan server. Cek console.");
                    console.error(xhr);
                }
            },
            complete: function() {
                // kembalikan tombol
                $btn.prop('disabled', false).html('<i class="fa fa-save"></i> SIMPAN VERIFIKASI');
            }
        });
    });

    $(function(){
        loadRiwayat();
    });
</script>
@endsection