<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DisposisiPengajuanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;
    public $pengirim;
    public $catatan;

    public function __construct($pengajuan, $pengirim, $catatan = null)
    {
        $this->pengajuan = $pengajuan;
        $this->pengirim = $pengirim;
        $this->catatan  = $catatan;
    }

    public function build()
    {
        return $this->subject('[DISPOSISI] Pengajuan #' . $this->pengajuan->no_permohonan)
                    ->markdown('emails.disposisi_pengajuan');
    }
}
